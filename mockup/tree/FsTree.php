<?php
use Tree\Node\Node;

class FsTree
{
	private Node $node;
	
	
	public function __construct ()
	{
		$this->node = new Node();
	}
	
	
	public function scan ($base)
	{
		$this->node->setValue(realpath($base));
		$d = dir($base);
		while (false !== ($file = $d->read()))
		{
			if(strpos($file, ".") !== 0)
			{
				$this->node->addChild(new Node($file));
				//TODO recursive
			}
		}
		$d->close();
	}
	
	
	protected static function fromNode ($node)
	{
		$fst = new FsTree();
		$fst->node = $node;
		return $fst;
	}
	
	
	public function print ()
	{
		$depth = $this->node->getDepth();
		echo str_repeat("\t", $depth) . $this->node->getValue() . "<br/>" . PHP_EOL;
		foreach ($this->node->getChildren() as $child)
		{
			$fst_child = FsTree::fromNode($child);
			$fst_child->print();
		}
	}
	
}
