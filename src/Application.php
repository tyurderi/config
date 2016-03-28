<?php

namespace TM\Config;

use TM\Config\Components\Database;

class Application
{

    /**
     * @var array
     */
    protected $config;

    /**
     * @var string
     */
    protected $appDir;

    /**
     * @var Database
     */
    protected $db;

    public function __construct($config)
    {
        $this->config = is_string($config) && is_file($config) ? include $config : $config;
        $this->appDir = dirname(__DIR__);
        $this->db     = new Database($this);
    }

    public function createConfig($type = Type::MULTIPLE)
    {
        return new Config($type);
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