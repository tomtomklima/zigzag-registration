<?php

namespace Zigzag\Logging;

interface Logging {
	public function logUsage($username, $place, $action, $details, $database);
	
	public function logError(\Exception $e);
}