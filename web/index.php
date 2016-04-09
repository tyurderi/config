<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$appDir = dirname(__DIR__);

/** @var TM\Config\Web\Application $app */
$app    = TM\Config\Web\Application::getInstance($appDir . '/config.inc.php');

$app->run();