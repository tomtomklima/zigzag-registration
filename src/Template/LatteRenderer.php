<?php

namespace Zigzag\Template;

use Zigzag;
use Http\HttpRequest;
use Plasticbrain\FlashMessages\FlashMessages;
use Latte\Engine;

class LatteRenderer implements Renderer {
	private $renderer;
	private $rootUrl;
	private $flashMessages;
	private $request;
	
	public function __construct($rootUrl, FlashMessages $flashMessages, HttpRequest $request) {
		$this->renderer = new Engine();
		$this->renderer->setTempDirectory('Temp');
		$this->rootUrl = $rootUrl;
		$this->flashMessages = $flashMessages;
		$this->request = $request;
	}
	
	public function render($template, $data = []) {
		//add root uri path
		$data['ROOT'] = $this->rootUrl;
		
		//add flash messages
		$data['messages'] = $this->flashMessages;
		
		//register Latte custom filters
		$this->renderer->addFilter('intoCzechMonths', function($idOfMonth) {
			$months = [
				'leden',
				'únor',
				'březen',
				'duben',
				'květen',
				'červen',
				'červenec',
				'srpen',
				'září',
				'říjen',
				'listopad',
				'prosinec'
			];
			
			return $months[$idOfMonth - 1];
		});
		
		//render into cache
		ob_start();
		$this->renderer->render(__DIR__."/Templates/$template.latte", $data);
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}
}