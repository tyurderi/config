<?php

namespace TM\Config\Components;

use TM\Config\Application;

abstract class ComponentAbstract
{

    /**
     * @var Application
     */
    protected $app;

    final public function __construct(Application $app)
    {
        $this->app = $app;
        $this->initialize();
    }

    abstract public function initialize();

}