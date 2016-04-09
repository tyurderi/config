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

        $this->register('/', 'index.index');
    }

    public function run()
    {
        $this->slim->run();
    }

    public function getSlim()
    {
        return $this->slim;
    }

    protected function register($route, $target, $method = 'GET')
    {
        list($controller, $action) = $this->parseTarget($target);

        if(class_exists($controller) && method_exists($this->slim, $method))
        {
            $self    = $this;
            $closure = function($request, $response, $params) use ($self, $controller, $action) {
                /** @var ControllerAbstract $controller */
                $controller = new $controller($self);

                return $controller->dispatch($action, $params);
            };

            $this->slim->map(array($method), $route, $closure);
        }
    }

    private function parseTarget($target)
    {
        $result = explode('.', $target, 2);

        $result[0] = 'TM\\Config\\Web\\Controllers\\' . ucfirst($result[0]) . 'Controller';

        return $result;
    }

}