<?php

namespace Zigzag\Models;

use Dibi\Connection;

class Forms {
	private $database;
	
	public function __construct(Connection $database) {
		$this->database = $database;
	}
	
	public function getDummyDataForMainForm() {
		$result = $this->database->query('SELECT `events`.`id` AS `eventId`, 
										  `events`.`name` AS `eventName`, 
										  `events`.`description` AS `eventDescription`,
	                                	  `categories`.`id` AS `categories`, `categories`.`id` AS `categoryId`, 
	                                	  `categories`.`name` AS `categoryName`, 
	                                	  `categories`.`description` AS `categoryDescription`, 
	                                	  `options`.`id` AS `options`, `options`.`id` AS `optionId`, 
	                                	  `options`.`name` AS `optionName`, 
	                                	  `options`.`info` AS `optionInfo`
	                                	  FROM `events`
								    	  JOIN `categories` ON `events`.`id` = `categories`.`eventId`
								    	  JOIN `options` ON `categories`.`id` = `options`.`categoryId`');
		
		return $result->fetchAssoc('=,categories,=,options');
	}
}