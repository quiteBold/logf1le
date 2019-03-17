<?php

// @author Simon Kühn
//

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

$logFile = "/home/sites/site32/logs/web.err.log";


if(file_exists($logFile)) {
	echo "<pre>";
	readfile($logFile);
	echo "</pre>";
} else {
	var_dump(ABSPATH);
}
