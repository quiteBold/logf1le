<?php

	error_reporting(E_ALL);

// @author Simon Kühn
//

$logFile = 'web.err.log';
$logFileDir = '/home/sites/site32/logs/';
$output = '<h1>Manitu Log File Analyser</h1>'."\n";
$logFileTable = '';
$logFileArray = [];

$header = '<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link rel="stylesheet" type="text/css" href="normalize.css" />
		<link rel="stylesheet" type="text/css" href="stylesheet.css" />

    <title>Manitu Log File Analyser</title>
  </head>
  <body>';

$footer = '  </body>
</html>';


// If file exists, then read it and make a nice Table out of it
if(file_exists($logFileDir.$logFile)) {
	$logFileArray = file($logFileDir.$logFile);

	$output .= "<h3>Content of " . $logFile . "</h3>\n";
	$output .= "<table>\n";
	$output .= "<tr><th>Line</th><th>Date</th><th>Time</th><th>Type</th><th>Client</th><th>Message</th></tr>\n";

	// iterate through lines in $logFileArray and make nice table rows
	foreach ($logFileArray as $line => $value) {

		// open table row and line number
		$logFileTable .= '<tr><td>'.($line+1).'</td>';

		// Time Stamp
		$ts = date_parse(substr($value, 1, 24));
		$logFileTable .= '<td>'.$ts['year'].'-'.$ts['month'].'-'.$ts['day'].'</td>';
		$logFileTable .= '<td>'.$ts['hour'].':'.$ts['minute'].'</td>';
		$value = substr($value, 28);

		// Error Type
		$logFileTable .= '<td>'.strstr($value, ']', true).'</td>';
		$value = substr(strstr($value, ']'), 2);

		// Client IP
		// there are occurences of no client ip detected.
		if(strstr($value, ']')) { // if yes, then extract IP and shorten
			$value = substr($value, 8);
			$logFileTable .= '<td>'.strstr($value, ']', true).'</td>';
			$value = substr(strstr($value, ']'), 1);
		} else { // if not, then print a hint
			$logFileTable .= '<td>No client detected!<br />See weblog.</td>';
		}

		//ErrorMessage
		$logFileTable .= '<td>'.str_replace(',', '<br />', $value).'</td>';

		//close table row
		$logFileTable .= '</tr>';
	}

	$output .= $logFileTable;
	$output .= "</table>\n";

} else { // if file does not exist, show the directory 
	$output .= "<h3>Error: File does not exist. </h3>\n";
	$output .= "<p>Showing directory instead.<p>\n";
	$output .= "<ul>\n<li>";
	$output .= implode("</li>\n<li>", scandir($logFileDir));
	$output .= "</li>\n</ul>";
}

echo $header;
echo $output;
echo $footer;
