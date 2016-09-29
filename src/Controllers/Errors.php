<?php

namespace Zigzag\Controllers;

class Errors extends BaseController {
	
	public function _404() {
		$html = $this->renderer->render('404');
		$this->response->setContent($html);
	}
	
	public function _405($parameters) {
		$data['allowedMethods'] = $parameters['allowedMethods'];
		$html = $this->renderer->render('405', $data);
		$this->response->setContent($html);
	}
}