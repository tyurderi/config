<?php

ini_set('display_errors', 'on');
error_reporting(E_ALL);

require_once dirname(__DIR__) . '/vendor/autoload.php';

$appDir = dirname(__DIR__);

/** @var TM\Config\Web\Application $app */
$app    = TM\Config\Web\Application::getInstance($appDir . '/config.inc.php');

$app->run();