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
	
	protected function getPreviousMonth($year, $month) {
		if (12 >= $month && $month > 1) {
			return [$year, $month - 1];
		}
		elseif ($month == 1) {
			return [$year - 1, 12];
		}
		else {
			throw new UnexpectedValueException('Vloženo neplatné číslo měsíce');
		}
	}
	
	protected function accessRejected() {
		throw new \RbacException ('Přístup odepřen', 403);
	}
}