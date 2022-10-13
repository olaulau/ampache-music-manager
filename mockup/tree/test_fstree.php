<?php
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/FsTree.php";

echo "<pre>" . PHP_EOL;

$fst = new FsTree();
$fst->scan(__DIR__);
$fst->print();

echo "</pre>" . PHP_EOL;
