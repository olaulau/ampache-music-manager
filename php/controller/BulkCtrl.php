<?php
namespace controller;

use Base;
use Cache;
use \classes\FsTree;
use Tree\Node\Node;
use View;

class BulkCtrl extends Ctrl
{

	public static function beforeRoute (Base $f3, array $params, string $controller)
	{
		parent::beforeRoute($f3, $params, $controller);
	}
    
	
	public static function afterRoute (Base $f3, array $params, string $controller)
	{
		parent::afterRoute($f3, $params, $controller);
	}

	
	private static function renameFilterTree(Node $node, string $search)
	{
		foreach ($node->getChildren() as $child)
		{
			if(!$child->isLeaf()) {
				self::renameFilterTree($child, $search);
			}
			elseif($child->getDepth() !== 3) { // ?
				$node->removeChild($child);
			}
			elseif(!str_contains($child->getValue(), $search)) {
				$node->removeChild($child);
			}
		}
		if($node->isLeaf() && !$node->isRoot() && $node->getDepth() !== 3) {
			$node->getParent()->removeChild($node);
		}
	}
	
	public static function renameGET (Base $f3, array $params, string $controller)
	{
		$cache = Cache::instance();
		
		$root_path = $cache->get("config.root_path");
		$library = $cache->get("config.library");
		$library_base = $root_path . DIRECTORY_SEPARATOR . $library;
		
		$search_text =  $f3->get("REQUEST.search_text");
		if(!empty($search_text)) {
			$fst = new FsTree($library_base);
			$fst->scan("is_dir", 3);
			if(!empty($search_text))
				self::renameFilterTree($fst, $search_text);
			$f3->set("fst", $fst);
		}
		
		$view = new View();
		echo $view->render('bulk/rename.phtml');
	}
	
	
	public static function renamePOST (Base $f3, array $params, string $controller)
	{
		
	}
	
}
