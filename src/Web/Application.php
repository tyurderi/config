<?php

namespace TM\Config\Web;

class Application extends \TM\Config\Application
{

    /**
     * @var \Slim\App
     */
    protected $slim;

    public function initialize($config)
    {
        parent::initialize($config);

        $this->slim = new \Slim\App(array(
            'settings' => array(
                'displayErrorDetails' => true
            )
        ));

        $this->get('/', 'index.index');

        $this->any('/search', 'index.search');
    }

    public function run()
    {
        $this->slim->run();
    }

    public function getSlim()
    {
        return $this->slim;
    }

    public function get($route, $target)
    {
        return $this->map($route, $target, array('GET'));
    }

    public function post($route, $target)
    {
        return $this->map($route, $target, array('POST'));
    }

    public function any($route, $target)
    {
        return $this->map($route, $target, array('GET', 'POST'));
    }

    protected function map($route, $target, $methods = array())
    {
        list($controller, $action) = $this->parseTarget($target);

        if(class_exists($controller))
        {
            $self    = $this;
            $closure = function($request, $response, $params) use ($self, $controller, $action) {
                /** @var ControllerAbstract $controller */
                $controller = new $controller($self);

                return $controller->dispatch($action, $params);
            };

            return $this->slim->map($methods, $route, $closure);
        }
    }

    private function parseTarget($target)
    {
        $result = explode('.', $target, 2);

        $result[0] = 'TM\\Config\\Web\\Controllers\\' . ucfirst($result[0]) . 'Controller';

        return $result;
    }

}