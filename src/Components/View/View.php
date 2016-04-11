<?php

namespace TM\Config\Components\View;

use TM\Config\Components\ComponentAbstract;

class View extends ComponentAbstract
{

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var \Twig_Loader_Filesystem
     */
    protected $loader;

    /**
     * @var string
     */
    protected $viewDirectory;

    /**
     * @var array
     */
    protected $context;

    /**
     * @var string
     */
    protected $viewName;

    public function initialize()
    {
        $this->viewDirectory = $this->app->getAppDir() . '/src/Web/Views/';

        $this->loader = new \Twig_Loader_Filesystem($this->viewDirectory);
        $this->twig   = new \Twig_Environment($this->loader, array(
            'autoescape'  => false,
            'auto_reload' => true,
            'cache'       => $this->app->getAppDir() . '/var/cache/twig/'
        ));

        $this->context  = array();
        $this->viewName = 'index/index';

        $this->twig->addExtension(new Extension($this->app));
    }

    public function exists($name)
    {
        return $this->loader->exists(
            $this->getName($name)
        );
    }

    public function render($name, $context = array())
    {
        return $this->twig->render(
            $this->getName($name),
            array_merge($this->context, $context)
        );
    }

    public function pick($name)
    {
        $this->viewName = $name;

        return $this;
    }

    public function finish($context = array())
    {
        return $this->render($this->viewName, $context);
    }

    public function assign($name, $value = array())
    {
        if(is_array($name))
        {
            $this->context = array_merge($this->context, $name);
        }
        else
        {
            $this->context[$name] = $value;
        }

        return $this;
    }

    public function clearAssign($name = null)
    {
        if($name === null)
        {
            $this->context = array();
        }
        else
        {
            if(isset($this->context[$name]))
            {
                unset($this->context[$name]);
            }
        }

        return $this;
    }

    private function getName($name)
    {
        return $name . '.twig';
    }

}