<?php
namespace classes;

use Tree\Node\Node;

class FsTree extends Node
{
	
	public function scan ($testFunc=null, $max_depth=null)
	{
		$files = scandir($this->getFullPath());
		foreach ($files as $file)
		{
			if(strpos($file, ".") !== 0) // don't bother with hidden files
			{
				$fullpath = $this->getFullPath() . DIRECTORY_SEPARATOR . $file;
				$depth = $this->getDepth()+1;
				
				// handle max_depth constraint
				if($max_depth === null || $depth <= $max_depth)
				{
					
					// handle test function
					if($testFunc === null  ||  $testFunc($fullpath))
					{
						$child = new FsTree($file);
						$this->addChild($child);
						
						if(is_dir($child->getFullPath()) && $depth !== $max_depth)
						{
							$child->scan($testFunc, $max_depth);
						}
					}
				}
			}
		}
	}
	
	
	public function printAsTree ()
	{
		$res = "";
		$depth = $this->getDepth();
		$res .= str_repeat("  ", $depth) . $this->getValue() . PHP_EOL;
		foreach ($this->getChildren() as $child)
		{
			$res .= $child->printAsTree();
		}
		return $res;
	}
	
	
	public function getFullPath ()
	{
		$nodeList = $this->getAncestorsAndSelf();
		$pathList = [];
		foreach ($nodeList as $node) {
			$pathList [] = $node->getValue();
		}
		return implode(DIRECTORY_SEPARATOR, $pathList);
	}
	
	
	public function getChildrenAsValuesArray ()
	{
		$children = $this->getChildren();
		$res = [];
		foreach ($children as $child) {
			$res [] = $child->getValue();
		}
		return $res;
	}
}
