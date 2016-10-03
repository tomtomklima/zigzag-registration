<?php

namespace Zigzag\Controllers;

class PublicForms extends BaseController {
	
	public function mainForm() {
		$html = $this->renderer->render('mainForm');
		$this->response->setContent($html);
	}
}