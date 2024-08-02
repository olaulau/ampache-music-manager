<?php
namespace controller;

use AmpacheApi\AmpacheApi;


class AmpacheCtrl extends Ctrl
{

	public static function beforeRoute ()
	{
		parent::beforeRoute();
	}
    
	
	public static function afterRoute ()
	{
		parent::afterRoute();
	}

	
	public static function testGET ()
	{
		function debug_event () {}

		$f3 = \Base::instance();
		$cache = \Cache::instance();

		$ampache = new AmpacheApi (
			[
				'username'			=> $f3->get("ampache.username"),	// Username
				'password'			=> $f3->get("ampache.password"),	// Password
				'server'			=> $f3->get("ampache.hostname"),	// Server address, without http/https prefix
				'debug_callback'	=> 'controller\debug_event',		// server callback function
				'api_secure'		=> $f3->get("ampache.secure"),		// Set to true to use https
				'api_version'		=> 6,								// Set API response version. 3, 4, 5, 6 (default: 6)
				'api_format'		=> 'json',							// Set API response format. xml, json (default: json)
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

		
		
		$view = new \View();
		echo $view->render('ampache/test.phtml');
	}
	
}
