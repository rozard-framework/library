<?php


$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($url);
parse_str($parts['query'], $query);
echo $query['data'];

 





// Store the file name into variable
$file = '../../../../../data/'. $query['data'];

// Header content type
header('Content-type: application/pdf');

header('Content-Disposition: inline; filename="' . $file . '"');

header('Content-Transfer-Encoding: binary');

header('Accept-Ranges: bytes');



// Read the file
@readfile($file);