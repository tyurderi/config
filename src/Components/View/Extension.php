<?php

namespace TM\Config\Components\View;

use TM\Config\Web\Application;

class Extension extends \Twig_Extension
{

    /**
     * @var Application
     */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getName()
    {
        return 'View Extension';
    }

    public function getFunctions()
    {
        $functions = array('url', 'resource_url');
        $result    = array();

        foreach($functions as $functionName)
        {
            $result[] = new \Twig_SimpleFunction($functionName, array($this, $functionName . 'Function'));
        }

        return $result;
    }

    public function urlFunction($target = '')
    {
        /** @var \Slim\Http\Request $request */
        $request = $this->app->getSlim()->getContainer()->get('request');
        $uri     = $request->getUri();

        return $uri . $target;
    }

    public function resource_urlFunction($target)
    {
        return $this->urlFunction('resources/' . $target);
    }

}