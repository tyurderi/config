<?php

namespace TM\Config;

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

    public function __construct($configFile)
    {
        $this->config = include $configFile;
        $this->appDir = dirname(__DIR__);
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