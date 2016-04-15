# Complex PHP Configuration

Build from the following code easily a configuration application.

``` php
require_once dirname(__DIR__) . '/vendor/autoload.php';

$appDir = dirname(__DIR__);
$app    = TM\Config\Application::getInstance($appDir . '/config.inc.php');

$nameList = new \TM\Config\Config(\TM\Config\Type::MULTIPLE);
$nameList->setName('name')
         ->setLabel('Names');

$nameList->addField('name', TM\Config\Field\Type::string(32));

$nameList->setColumns(array(
    'name'
));

$app->Modules()->Manager()->register($nameList);

$app->Modules()->DB()->insert('name', array('name' => 'Max'))->execute();

$name = TM\Config\Model\Proxy\Name::find();
echo $name->getName(), PHP_EOL;
```

# Result
![Result Image]