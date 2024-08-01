<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/conf.php";

use AmpacheApi\AmpacheApi;


function debug_event () {}
$ampache = new AmpacheApi(
	[
		'username'			=> $conf["username"],	// Username
		'password'			=> $conf["password"],	// Password
		'server'			=> $conf["hostname"],	// Server address, without http/https prefix
		'debug_callback'	=> 'debug_event',		// server callback function
		'api_secure'		=> $conf["secure"],		// Set to true to use https
		'api_version'		=> 6,					// Set API response version. 3, 4, 5, 6 (default: 6)
		'api_format'		=> 'json',				// Set API response format. xml, json (default: json)
	]
);
if ($ampache->state() != 'CONNECTED') {
	echo "Ampache API client failed to connected.".PHP_EOL;
	exit;
}
 
// Get server stats
$stats = $ampache->info();
echo "Songs: " . $stats["songs"] . "<br />".PHP_EOL;
echo "Albums: " . $stats["albums"] . "<br />".PHP_EOL;
echo "Artists: " . $stats["artists"] . "<br />".PHP_EOL;
echo "Playlists: " . $stats["playlists"] . "<br />".PHP_EOL;
//  echo "Videos: " . $stats["videos"] . "<br />".PHP_EOL;
 
// Get all artists
$total = $stats["artists"];
$step = 500; // Request per 500
echo "Artists: <br />".PHP_EOL;
$start = 0;
while ($total > $start) {
	$artists = $ampache->send_command('artists', ['offset' => $start, 'limit' => $step]);
	foreach ($artists as $artist) {
		echo "\t" . $artist ["artist"] ["name"] . "<br/>".PHP_EOL;
	}
	$start += count($artists);
}
