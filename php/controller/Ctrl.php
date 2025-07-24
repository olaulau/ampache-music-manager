<?php
namespace controller;

use Base;
use DB\SQL;

abstract class Ctrl
{
	public static function beforeRoute ()
	{
		$f3 = Base::instance();
		
		# get ampache conf
		$ampache_server_path = $f3->get("ampache.server.path");
		$ampache_conf_file = "{$ampache_server_path}/config/ampache.cfg.php";
		$ampache_conf = parse_ini_file($ampache_conf_file);
		
		# connect its DB
		$db = new SQL("mysql:host={$ampache_conf["database_hostname"]};port={$ampache_conf["database_port"]};dbname={$ampache_conf["database_name"]}", $ampache_conf["database_username"], $ampache_conf["database_password"]);
		$f3->set("db", $db);
	}
    
	
	public static function afterRoute ()
	{
		
	}

}
