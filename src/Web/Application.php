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

        $container  = new \Slim\Container(array(
            'settings' => array(
                'displayErrorDetails' => true
            )
        ));

        $this->slim = new \Slim\App($container);

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
            $slim = $this->slim;

            $this->slim->{$method}($route, function($request, $response, $params) use ($slim, $controller, $action) {
                /** @var ControllerAbstract $controller */
                $controller = new $controller($slim);

                return $controller->{$action}($request, $response, $params);
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