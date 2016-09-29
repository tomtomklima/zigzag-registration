<?php

namespace Zigzag;
use Dibi\Connection;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Http\HttpRequest;
use Http\HttpResponse;
use Plasticbrain\FlashMessages\FlashMessages;
use Zigzag\Logging;
use Zigzag\Template\LatteRenderer;
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

//include config
require_once 'Config.php';

//psr-4 autoloading
require_once __DIR__.'/../vendor/autoload.php';


//LOGGING
$logger = new Logging\ Monolog('accessLogger', 'errorLogger');


//ERROR HANDLING
error_reporting(E_ALL);

//Register the error handlers
$whoops = new Run;
if (ENVIRONMENT == 'development') {
	$whoops->pushHandler(new PrettyPageHandler);
}
else {
	$whoops->pushHandler(function(\Exception $e) use ($logger) {
		$logger->logError($e);
		require_once('Template/ErrorPage.php');
	});
}
$whoops->register();
//throw new \Exception; //example


//HTTP REQUEST & RESPONSES
$request = new HttpRequest($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
$response = new HttpResponse;

//DATABASE INFO
if (ENVIRONMENT == 'development') {
	$options = [
		'driver' => DEV_DRIVER,
		'host' => DEV_HOST,
		'username' => DEV_USERNAME,
		'password' => DEV_PASSWORD,
		'database' => DEV_DATABASE_NAME,
	];
}
else if (ENVIRONMENT == 'production') {
	$options = [
		'driver' => PROD_DRIVER,
		'host' => PROD_HOST,
		'username' => PROD_USERNAME,
		'password' => PROD_PASSWORD,
		'database' => PROD_DATABASE_NAME,
	];
}
else {
	throw new \UnexpectedValueException('Unexpected value in ENVIRONMENT constant');
}
$database = new Connection($options);


//AUTHORIZATION - ROLE BASED ACCESS CONTROLL - http://phprbac.net/
//db config at vendor/owasp/phprbac/PhpRbac/database/database.config
$authorization = new RbacPermisions();

//initialize with base data if empty permissions
try {
	$authorization->checkPermission(0, 'access');
} catch (\RbacException $e) {
	$authorization->initializeUsersWitRoles();
}


//AUTHENTICATION
session_start();
if (isset($_SESSION['userId'], $_SESSION['loginString'], $_SESSION['userName']))
	$user = new User($_SESSION['userId'], $_SESSION['loginString'], $_SESSION['userName'], $authorization);
else
	$user = new User(null, null, null, $authorization);

//TODO add CSRF protection
//https://github.com/volnix/csrf


//TEMPLATING
//flash messages from https://github.com/plasticbrain/PhpFlashMessages
$flashMessages = new FlashMessages();
$menuRenderer = new ArrayMenuReader($user, ROOT);
$renderer = new LatteRenderer($menuRenderer, ROOT, $flashMessages, $request);


//ROUTER
$routeDefinitionCallback = function(RouteCollector $r) {
	$routes = include('Routes.php');
	foreach ($routes as $route) {
		$r->addRoute($route[0], ROUTER_URI.$route[1], $route[2]);
	}
};

$dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);
$routeInfo = $dispatcher->dispatch($request->getMethod(), rtrim($request->getUri(), '/'));
switch ($routeInfo[0]) {
	case Dispatcher::FOUND:
		$className = $routeInfo[1][0];
		$method = $routeInfo[1][1];
		$vars = $routeInfo[2];
		break;
	case Dispatcher::METHOD_NOT_ALLOWED:
		$response->setStatusCode(405);
		$className = 'Zigzag\Controllers\Errors';
		$method = '_405';
		$vars = ['allowedMethods' => $routeInfo[1]];
		break;
	case Dispatcher::NOT_FOUND:
	default;
		$response->setStatusCode(404);
		$className = 'Zigzag\Controllers\Errors';
		$method = '_404';
		$vars = [];
		break;
}
$class = new $className($request, $response, $renderer, $database, $user, ROOT, $flashMessages);
//rock magic!
$class->$method($vars);

//log action
$logger->logUsage($user->getUsername(), $className, $method, $vars, $database);

//render
foreach ($response->getHeaders() as $header) {
	header($header, false);
}
echo $response->getContent();