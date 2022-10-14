<?php
use Tree\Node\Node;

class FsTree
{
	private Node $node;
	
	
	public function __construct ($value)
	{
		if($value instanceof Node)
		{
			$this->node = $value;
		}
		else
		{
			$this->node = new Node($value);
		}
	}
	
	
	public function scan ()
	{
		$files = scandir($this->getFullPath());
		foreach ($files as $file)
		{
			if(strpos($file, ".") !== 0)
			{
				$child = new Node($file);
				$this->node->addChild($child);
				
				$fst = new FsTree($child);
				if(is_dir($fst->getFullPath()))
				{
					$fst->scan();
				}
			}
		}
	}
	
	
	public function printAsTree ()
	{
		$depth = $this->node->getDepth();
		echo str_repeat("  ", $depth) . $this->node->getValue() . PHP_EOL;
		foreach ($this->node->getChildren() as $child)
		{
			$fst_child = new FsTree($child);
			$fst_child->printAsTree();
		}
	}
	
	
	public function getFullPath ()
	{
		$nodeList = $this->node->getAncestorsAndSelf();
		$pathList = [];
		foreach ($nodeList as $node) {
			$pathList [] = $node->getValue();
		}
		return implode("/", $pathList);
	}
	
}
