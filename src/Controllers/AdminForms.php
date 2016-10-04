<?php

namespace Zigzag\Controllers;

class AdminForms extends BaseController {
	
	public function createEventForm() {
		if ($this->checkAdminAccess(\Zigzag\USERS)) {
			$html = $this->renderer->render('createEventForm');
			$this->response->setContent($html);
		}
	}
}