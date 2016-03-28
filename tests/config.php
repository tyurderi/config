<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$appDir = dirname(__DIR__);
$app    = new TM\Config\Application($appDir . '/config.inc.php');