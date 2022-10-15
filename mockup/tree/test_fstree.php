<?php
require_once __DIR__ . "/FsTree.php";

echo "<pre>" . PHP_EOL;

$fst = new FsTree(__DIR__);
$fst->scan("is_dir");
$fst->printAsTree();

echo "</pre>" . PHP_EOL;
