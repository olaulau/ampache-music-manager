<?php
namespace controller;

use AmpacheApi\AmpacheApi;
use Base;
use Cache;
use DB\CortexCollection;
use DB\SQL;
use ErrorException;
use model\Album;
use model\Catalog;
use model\CatalogLocal;
use View;


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

	
	static function debug_event () {}
	
	
	public static function statsGET ()
	{
		$f3 = \Base::instance();
		
		$ampache = new AmpacheApi (
			[
				'username'			=> $f3->get("ampache.api.username"),	// Username
				'password'			=> $f3->get("ampache.api.password"),	// Password
				'server'			=> $f3->get("ampache.api.hostname"),	// Server address, without http/https prefix
				'debug_callback'	=> self::class . '::debug_event',		// server callback function
				'api_secure'		=> $f3->get("ampache.api.secure"),		// Set to true to use https
				'api_version'		=> "6",									// Set API response version. 3, 4, 5, 6 (default: 6)
				'api_format'		=> "json",								// Set API response format. xml, json (default: json)
				"debug"				=>	false,
			]
		);
		if ($ampache->state() != 'CONNECTED') {
			echo "Ampache API client failed to connect." . PHP_EOL;
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

		
		echo "<h1> QUERY ALL </h1>";

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
		echo "Artists: {$artists ["total_count"]} <br />" . PHP_EOL;
		
		// Get all albums
		$albums = $ampache->send_command('albums');
		echo "Albums: {$albums ["total_count"]} <br />" . PHP_EOL;
		
		// Get all songs
		$songs = $ampache->send_command('songs');
		echo "Songs: {$songs ["total_count"]} <br />" . PHP_EOL;
		var_dump($songs ["song"] [0]);
		die;
		
		// Get all playlists
		$playlists = $ampache->send_command('playlists');
		echo "Playlists: {$playlists ["total_count"]} <br />" . PHP_EOL;
		
		// $view = new \View();
		// echo $view->render('ampache/stats.phtml');
	}
	
	
	public static function navigateGET ()
	{
		$f3 = \Base::instance();
		
		$ampache = new AmpacheApi (
			[
				'username'			=> $f3->get("ampache.username"),	// Username
				'password'			=> $f3->get("ampache.password"),	// Password
				'server'			=> $f3->get("ampache.hostname"),	// Server address, without http/https prefix
				'debug_callback'	=> self::class . '::debug_event',	// server callback function
				'api_secure'		=> $f3->get("ampache.secure"),		// Set to true to use https
				'api_version'		=> "6",								// Set API response version. 3, 4, 5, 6 (default: 6)
				'api_format'		=> "json",							// Set API response format. xml, json (default: json)
				"debug"				=>	false,
			]
		);
		if ($ampache->state() != 'CONNECTED') {
			echo "Ampache API client failed to connect." . PHP_EOL;
			exit;
		}
		
		$song_id = 61852;
		
		// query a song by its id
		echo "<h2> song </h2>" . PHP_EOL;
		$song = $ampache->send_command('song', ["filter" => $song_id]);
		var_dump($song);
		$artist_id = $song ["artist"] ["id"];
		$album_id = $song ["album"] ["id"];
		
		// query album by its id
		echo "<h2> album </h2>" . PHP_EOL;
		$album = $ampache->send_command('album', ["filter" => $album_id]);
		var_dump($album);
		
		// query artist by its id
		echo "<h2> artist </h2>" . PHP_EOL;
		$artist = $ampache->send_command('artist', ["filter" => $artist_id]);
		var_dump($artist);
		
		// get album songs
		echo "<h2> album songs </h2>" . PHP_EOL;
		$songs = $ampache->send_command('album_songs', ["filter" => $album_id]);
		var_dump($songs);
		
		die;
	}
	
	
	public static function testGET ()
	{
		$f3 = Base::instance();
		
		# get ampache conf
		$ampache_server_path = $f3->get("ampache.server.path");
		$ampache_conf_file = "{$ampache_server_path}/config/ampache.cfg.php";
		$ampache_conf = parse_ini_file($ampache_conf_file);
		
		# connect its DB
		$db = new SQL("mysql:host={$ampache_conf["database_hostname"]};port={$ampache_conf["database_port"]};dbname={$ampache_conf["database_name"]}", $ampache_conf["database_username"], $ampache_conf["database_password"]);
		$f3->set("db", $db);
		
		# get all catalogs
		$catalogs = (new Catalog)->find([], []);
		$f3->set("catalogs", $catalogs);
		
		# query album diff
		$src_catalog_id = $f3->get("REQUEST.src_catalog_id");
		$dest_catalog_id = $f3->get("REQUEST.dest_catalog_id");
		if (!empty($src_catalog_id) && !empty($dest_catalog_id)) {
			$catalogs_by_id = $catalogs->getBy("id");
			if (empty($catalogs_by_id [$src_catalog_id]) || empty($catalogs_by_id [$dest_catalog_id])) {
				throw new ErrorException("catalogs not found");
			}
			
			$sql = "
				SELECT	album_artist, year, al.prefix, al.name, al.id
				FROM	`album` as al
				INNER JOIN	artist ar ON al.album_artist = ar.id
				WHERE	catalog = ?
				AND		album_artist IS NOT NULL
				AND (album_artist, year, al.prefix, al.name) NOT IN
				(
					SELECT	al2.album_artist, al2.year, al2.prefix, al2.name
					FROM	album al2
					WHERE	catalog = ?
				)
				ORDER BY ar.name, al.prefix, al.name
			";
			$params = [$src_catalog_id, $dest_catalog_id];
			$albums = (new Album)->findByRawSQL($sql, $params);
			
			$albums_by_artist = $albums->getBy("album_artist", true);
			$f3->set("albums_by_artist", $albums_by_artist);
			
			$artists = [];
			foreach ($albums_by_artist as $artist_id => $albums) {
				foreach ($albums as $album) {
					$artists [$artist_id] = $album->album_artist;
				}
			}
			$f3->set("artists", $artists);
		}
		
		$view = new View();
		echo $view->render('ampache/test.phtml');
	}
	
}
