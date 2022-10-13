<?php
require_once __DIR__ . "/vendor/autoload.php";

use Tree\Node\Node;

$node = new Node('foo');
echo $node->getValue();
