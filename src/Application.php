<?php

namespace TM\Config;

class Application
{

    protected static $instance  = null;

    /**
     * @var Modules
     */
    protected $modules;

    /**
     * @var string
     */
    protected $appDir;

    /**
     * @var array
     */
    protected $config;

    public static function getInstance($config = null)
    {
        if(self::$instance === null)
        {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    private function __construct($config)
    {
        $this->config  = is_string($config) && is_file($config) ? include $config : $config;
        $this->appDir  = dirname(__DIR__);
        $this->modules = new Modules($this);
    }

    public function Modules()
    {
        return $this->modules;
    }

    public function getAppDir()
    {
        return $this->appDir;
    }

    public function getConfig($path = null)
    {
        if(empty($path))
        {
            return $this->config;
        }
        else
        {
            $segments     = explode('.', $path);
            $segmentCount = count($segments);
            $config       = $this->config;

            foreach($segments as $i => $segment)
            {
                if(isset($config[$segment]))
                {
                    if($i == $segmentCount - 1)
                    {
                        return $config[$segment];
                    }
                    else
                    {
                        $config = $config[$segment];
                    }
                }
                else
                {
                    return false;
                }
            }
        }
    }

}