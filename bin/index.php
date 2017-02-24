<?php

require_once('vendor/autoload.php');

use Indexer\Indexer;

$class = new Indexer();

$class->indexAndWrite('output/test.json', 'test/TestClass.php');
$class->indexAndWrite('output/php5.json', 'test/PHP5Class.php');
