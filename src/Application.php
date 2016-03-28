<?php

namespace TM\Config;

class Application
{

    /**
     * @var array
     */
    protected $config;

    public function __construct($configFile)
    {
        $this->config = include $configFile;
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