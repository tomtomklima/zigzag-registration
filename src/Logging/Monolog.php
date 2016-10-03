<?php

namespace Zigzag\Logging;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Monolog implements Logging {
	private $accessLogger;
	private $errorLogger;
	
	public function __construct($accessLogger, $errorLogger) {
		$this->accessLogger = new Logger($accessLogger);
		$this->accessLogger->pushHandler(new StreamHandler('access.log'));
		
		$this->errorLogger = new Logger($errorLogger);
		$this->errorLogger->pushHandler(new StreamHandler('errors.log'));
	}
	
	public function logUsage($username, $place, $action, $details, $database) {
		if ($username === null) {
			$username = '~non-logged user~';
		}
		$this->accessLogger->info('User '.$username.' in '.$place.' performs action '.$action.' with parameters ', $details);
	}
	
	public function logError(\Exception $e) {
		$this->errorLogger->error('Exception has been occured in file '.$e->getFile().' in line '.$e->getLine().' with code '.$e->getCode().' and message '.$e->getMessage().'. '.PHP_EOL.'Error trace: '.$e->getTraceAsString());
	}
}