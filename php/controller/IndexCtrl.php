<?php
namespace controller;

use \classes\FsTree;

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
		
		if($root_path_valid === true)
		{
			$fst = new FsTree($root_path);
			$fst->scan("is_dir", 1);
			$libraries = $fst->getChildrenAsValuesArray();
			$f3->set("libraries", $libraries);
			
			$library = $cache->get("config.library");
			$f3->set("library", $library);
		}
		
		$view = new \View();
		echo $view->render('index.phtml');
	}
	
	
	public static function indexPOST ()
	{
		$f3 = \Base::instance();
		$cache = \Cache::instance();
		
		$root_path = $f3->get("REQUEST.root_path");
		if(!empty($root_path))
		{
			$cache->set("config.root_path", $root_path);
		}
		
		$library = $f3->get("REQUEST.library");
		if(!empty($library))
		{
			$cache->set("config.library", $library);
		}
		
		$f3->reroute("@homepage");
	}
	
}
