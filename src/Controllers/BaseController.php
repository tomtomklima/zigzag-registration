<?php

namespace Zigzag\Controllers;

use Http\Request;
use Http\Response;
use Plasticbrain\FlashMessages\FlashMessages;
use Zigzag\Template\LatteRenderer;
use Dibi\Connection;

class BaseController {
	protected $request;
	protected $response;
	protected $renderer;
	protected $database;
	protected $root;
	protected $flashMessages;
	
	public function __construct(Request $request, Response $response, LatteRenderer $renderer, Connection $database, $root, FlashMessages $flashMessages) {
		$this->request = $request;
		$this->response = $response;
		$this->renderer = $renderer;
		$this->database = $database;
		$this->root = $root;
		$this->flashMessages = $flashMessages;
	}
	
	public function getPreviousMonth($year, $month) {
		if (12 >= $month && $month > 1) {
			return [$year, $month - 1];
		}
		elseif ($month == 1) {
			return [$year - 1, 12];
		}
		else {
			throw new \UnexpectedValueException('Vloženo neplatné číslo měsíce');
		}
	}
	
	public function checkAdminAccess($validAccesses = []) {
		$validUsers = array_keys($validAccesses);
		
		$user = @$_SERVER['PHP_AUTH_USER'];
		$pass = @$_SERVER['PHP_AUTH_PW'];
		
		$validated = (in_array($user, $validUsers)) && ($pass == $validAccesses[$user]);
		
		if (!$validated) {
			header('WWW-Authenticate: Basic realm="Zig-zag Form App"');
			header('HTTP/1.0 401 Unauthorized');
			die('Nesprávně zadané údaje pro přihlášení');
		} else {
			return true;
		}
	} 
}