<?php

namespace TM\Config\Components;

use TM\Config\Application;

abstract class Component
{

    /**
     * @var Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->initialize();
    }

    abstract public function initialize();

}