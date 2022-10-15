<?php
namespace controller;

class IndexCtrl extends Ctrl
{

	public static function beforeRoute ()
	{
		parent::beforeRoute();
	}
    
	
	public static function afterRoute ()
	{
		parent::afterRoute();
	}

	
	public static function indexGET ()
	{
		$f3 = \Base::instance();
		$cache = \Cache::instance();
		
		$root_path = $cache->get("config.root_path");
		$f3->set("root_path", $root_path);
		$root_path_valid = \file_exists($root_path) && is_dir($root_path) && \is_readable($root_path);
		$f3->set("root_path_valid", $root_path_valid);
		
		$view = new \View();
		echo $view->render('index.phtml');
	}
	
	
	public static function indexPOST ()
	{
		$f3 = \Base::instance();
		$cache = \Cache::instance();
		
		$root_path = $f3->get("REQUEST.root_path");
		$cache->set("config.root_path", $root_path);
		$f3->reroute("@homepage");
	}
	
}
