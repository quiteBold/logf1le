<?php

	error_reporting(E_ALL);

// @author Simon Kühn
//

$logFile = 'web.err.log';
$logFileDir = '/home/sites/site32/logs/';
$output = '<h1>Manitu Log File Analyser</h1>'."\n";
$logFileString = '';

$header = '<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manitu Log File Analyser</title>
  </head>
  <body>';

$footer = '  </body>
</html>';

if(file_exists($logFileDir.$logFile)) {
	$logFileString = file_get_contents($logFileDir.$logFile);
	$output .= "<h3>Content of " . $logFile . "</h3>\n";
	$output .= "<pre>\n";
	$output .= $logFileString;
	$output .= "</pre>\n";
} else {
	$output .= "<h3>Error: File does not exist. </h3>\n";
	$output .= "<p>Showing directory instead.<p>\n";
	$output .= "<ul>\n<li>";
	$output .= implode("</li>\n<li>", scandir($logFileDir));
	$output .= "</li>\n</ul>";
}

echo $header;
echo $output;
echo $footer;
