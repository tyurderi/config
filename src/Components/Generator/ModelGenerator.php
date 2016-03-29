<?php

namespace TM\Config\Components\Generator;

use TM\Config\Field\Field;
use TM\Config\Components\ComponentAbstract;

class ModelGenerator extends ComponentAbstract
{

    const MODEL_PROXY_DIR = '/src/Model/Proxy/';

    /**
     * @var string
     */
    protected $modelDirectory;

    public function initialize()
    {
        $this->modelDirectory = $this->app->getAppDir() . self::MODEL_PROXY_DIR;
    }

    /**
     * @param string  $name
     * @param Field[] $fields
     */
    public function generate($name, $fields)
    {
        $modelName = camelize($name);

    }

}