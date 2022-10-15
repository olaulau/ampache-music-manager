<?php
require_once __DIR__ . "/vendor/autoload.php";

use Tree\Node\Node;

class FsTree extends Node
{
	
	public function scan ($testFunc=null)
	{
		$files = scandir($this->getFullPath());
		foreach ($files as $file)
		{
			if(strpos($file, ".") !== 0) // don't bother with hidden files
			{
				if($testFunc === null  ||  $testFunc($this->getFullPath() . DIRECTORY_SEPARATOR . $file))
				{
					$child = new FsTree($file);
					$this->addChild($child);
					
					if(is_dir($child->getFullPath()))
					{
						$child->scan($testFunc);
					}
				}
			}
		}
	}
	
	
	public function printAsTree ()
	{
		$depth = $this->getDepth();
		echo str_repeat("  ", $depth) . $this->getValue() . PHP_EOL;
		foreach ($this->getChildren() as $child)
		{
			$child->printAsTree();
		}
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
	
}
