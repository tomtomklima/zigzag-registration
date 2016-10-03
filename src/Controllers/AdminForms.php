<?php

namespace Zigzag\Controllers;

class AdminForms extends BaseController {
	
	public function createEventForm() {
		$html = $this->renderer->render('createEventForm');
		$this->response->setContent($html);
	}
}