<?php

namespace TM\Config\Web;

abstract class ControllerAbstract
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

    protected function initialize()
    {

    }

    public function dispatch($action, $params = array())
    {
        $action = $action . 'Action';
        if(method_exists($this, $action))
        {
            $slim     = $this->app->getSlim();
            $request  = $slim->getContainer()->get('request');
            $response = $slim->getContainer()->get('response');

            return $this->{$action}($request, $response, $params);
        }

        return false;
    }

}