<?php

//withnout trailing slash
return [
	['GET', '', ['Zigzag\Controllers\PublicForms', 'mainForm']],
	['GET', '/admin', ['Zigzag\Controllers\AdminForms', 'createEventForm']],
];