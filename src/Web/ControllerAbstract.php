<?php

namespace TM\Config\Web;

abstract class ControllerAbstract
{

    final public function __construct(\Slim\App $slim)
    {
        $this->initialize();
    }

    protected function initialize()
    {

    }

}