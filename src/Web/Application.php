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

        $this->slim = new \Slim\App();

        $this->register('/', 'index.index');
    }

    public function run()
    {
        $this->slim->run();
    }

    protected function register($route, $target, $method = 'GET')
    {
        list($controller, $action) = $this->parseTarget($target);

        if(class_exists($controller) && method_exists($controller, $action))
        {
            $this->slim->{$method}($route, function($request, $response, $params) use($controller, $action) {
                /** @var ControllerAbstract $controller */
                $controller = new $controller();
                $controller->{$action}($request, $response, $params);
            });
        }
    }

    private function parseTarget($target)
    {
        $result = explode('.', $target, 2);

        $result[0] = 'TM\\Config\\Web\\Controllers\\' . ucfirst($result[0]) . 'Controller';
        $result[1] = $result[1] . 'Action';

        return $result;
    }

}