<?php

namespace TM\Config\Web;

abstract class ControllerAbstract
{

    /**
     * @var \Slim\App
     */
    protected $slim;

    final public function __construct(\Slim\App $slim)
    {
        $this->slim = $slim;

        $this->initialize();
    }

    protected function initialize()
    {

    }

    public function dispatch($action, $params = array())
    {
        $action = $action . 'Action';
        if(method_exists($this, $action))
        {
            $request  = $this->slim->getContainer()->get('request');
            $response = $this->slim->getContainer()->get('response');

            return $this->{$action}($request, $response, $params);
        }

        return false;
    }

}