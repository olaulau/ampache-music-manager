<?php
require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/FsTree.php";

echo "<pre>" . PHP_EOL;

$fst = new FsTree(__DIR__);
$fst->scan();
$fst->printAsTree();

echo "</pre>" . PHP_EOL;
