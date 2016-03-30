<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$appDir = dirname(__DIR__);
$app    = TM\Config\Application::getInstance($appDir . '/config.inc.php');

$nameList = $app->createConfig();
$nameList->setName('name')
         ->setLabel('Names');

$nameList->addField('name', TM\Config\Field\Type::string(32));

$nameList->setColumns(array(
    'name'
));

$app->getManager()->register($nameList);

$app->getDB()->insert('name', array('name' => 'Max'))->execute();

$name = TM\Config\Model\Proxy\Name::find();
echo $name->getName(), PHP_EOL;