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
		$f3 = \Base::instance();
		
		function debug_event () {}
		$ampache = new AmpacheApi (
			[
				'username'			=> $f3->get("ampache.username"),	// Username
				'password'			=> $f3->get("ampache.password"),	// Password
				'server'			=> $f3->get("ampache.hostname"),	// Server address, without http/https prefix
				'debug_callback'	=> 'controller\debug_event',		// server callback function
				'api_secure'		=> $f3->get("ampache.secure"),		// Set to true to use https
				'api_version'		=> "6",								// Set API response version. 3, 4, 5, 6 (default: 6)
				'api_format'		=> "json",							// Set API response format. xml, json (default: json)
				"debug"				=>	false,
			]
		);
		if ($ampache->state() != 'CONNECTED') {
			echo "Ampache API client failed to connected." . PHP_EOL;
			exit;
		}
		
		// Get server stats
		$stats = $ampache->info();
		// var_dump($stats);
		echo "<h1> STATS </h1>";
		echo "Catalogs: {$stats["catalogs"]} <br />" . PHP_EOL;
		echo "Artists: " . $stats["artists"] . " <br />" . PHP_EOL;
		echo "Albums: " . $stats["albums"] . " <br />" . PHP_EOL;
		echo "Songs: " . $stats["songs"] . " <br />" . PHP_EOL;
		echo "Playlists: " . $stats["playlists"] . " <br />" . PHP_EOL;
		echo "Videos: " . $stats["videos"] . " <br />" . PHP_EOL;
		
		
		echo "<hr>";

		
		echo "<h1> QUERIES </h1>";

		// Get all catalogs
		$catalogs = $ampache->send_command('catalogs', ["enabled" => "true"]);
		// var_dump($catalogs);
		echo "Catalogs: " . count($catalogs["catalog"]) . " <br />" . PHP_EOL;

		// Get a catalog
		$catalog = $ampache->send_command('catalog', ["filter" => "5"]);
		// var_dump($catalog);
		echo "Catalog #{$catalog["id"]} : {$catalog["name"]} ({$catalog["path"]}) <br />" . PHP_EOL;

		
		// Get all artists
		$artists = $ampache->send_command('artists');
		// var_dump($artists); die;
		echo "Artists: {$artists ["total_count"]} <br />" . PHP_EOL;
		
		// Get all albums
		$albums = $ampache->send_command('albums');
		echo "Albums: {$albums ["total_count"]} <br />" . PHP_EOL;
		
		// Get all songs
		$songs = $ampache->send_command('songs');
		echo "Songs: {$songs ["total_count"]} <br />" . PHP_EOL;
		
		// Get all playlists
		$playlists = $ampache->send_command('playlists');
		echo "Playlists: {$playlists ["total_count"]} <br />" . PHP_EOL;
		
		$view = new \View();
		echo $view->render('ampache/test.phtml');
	}
	
}
