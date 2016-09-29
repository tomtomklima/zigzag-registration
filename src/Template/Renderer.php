<?php

namespace Zigzag\Template;

interface Renderer {
	public function render($template, $data = []);
}