<?php

namespace Zigzag\Controllers;

use Dibi\Connection;
use Http\Request;
use Http\Response;
use Plasticbrain\FlashMessages\FlashMessages;
use Zigzag\Models\Forms;
use Zigzag\Template\LatteRenderer;

class PublicForms extends BaseController {
	
	private $forms;
	
	public function __construct(Request $request, Response $response, LatteRenderer $renderer, Connection $database, $root, FlashMessages $flashMessages) {
		parent::__construct($request, $response, $renderer, $database, $root, $flashMessages);
		$this->forms = new Forms($this->database);
	}
	
	public function mainForm() {
		
		$data = $this->forms->getDummyDataForMainForm();
		
		$html = $this->renderer->render('mainForm', $data);
		$this->response->setContent($html);
	}
}