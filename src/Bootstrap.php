<?php

namespace Zigzag;

use Dibi\Connection;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Http\HttpRequest;
use Http\HttpResponse;
use Plasticbrain\FlashMessages\FlashMessages;
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use Zigzag\Logging\Monolog;
use Zigzag\Template\LatteRenderer;

//include config
require_once 'Config.php';

//psr-4 autoloading
require_once __DIR__.'/../vendor/autoload.php';


//LOGGING
$logger = new Monolog('accessLogger', 'errorLogger');


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

session_start();    

//TEMPLATING
//flash messages from https://github.com/plasticbrain/PhpFlashMessages
$flashMessages = new FlashMessages();
$renderer = new LatteRenderer(ROOT, $flashMessages, $request);


//ROUTER
$routeDefinitionCallback = function(RouteCollector $r) {
	$routes = include('Routes.php');
	foreach ($routes as $route) {
		$r->addRoute($route[0], ROUTER_URI.$route[1], $route[2]);
	}
};

$dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);
$uri = rtrim($request->getUri());
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
$class = new $className($request, $response, $renderer, $database, ROOT, $flashMessages);
//rock magic!
$class->$method($vars);

//render
foreach ($response->getHeaders() as $header) {
	header($header, false);
}
echo $response->getContent();