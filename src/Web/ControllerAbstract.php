<?php

namespace TM\Config\Web;

use TM\Config\Components\Http\JsonResponse;
use TM\Config\Components\View\View;

abstract class ControllerAbstract
{

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var View
     */
    protected $view;

    /**
     * @var JsonResponse
     */
    protected $json;

    final public function __construct(Application $app)
    {
        $this->app  = $app;
        $this->view = $app->Modules()->View();
        $this->json = $app->Modules()->Json();

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