<?php

namespace TM\Config;

use Fuel\Dependency\Container;
use TM\Config\Components\Database;
use TM\Config\Components\Manager;
use TM\Config\Components\View\View;

class Modules
{

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Application
     */
    protected $app;

    public function __construct($app)
    {
        $this->container = new Container();
        $this->app       = $app;

        $this->container->register('database', function() {
            return new Database($this->app);
        });

        $this->container->register('manager', function() {
            return new Manager($this->app);
        });

        $this->container->register('view', function() {
            return new View($this->app);
        });
    }

    /** @return Database */
    public function DB()
    {
        return $this->container['database'];
    }

    /** @return Manager */
    public function Manager()
    {
        return $this->container['manager'];
    }

    /** @return View */
    public function View()
    {
        return $this->container['view'];
    }

}