<?php

$config = array(
    'database' => array(
        'host' => 'localhost',
        'user' => 'root',
        'pass' => 'vagrant',
        'shem' => 'test'
    )
);

if(is_file(__DIR__ . '/config.user.php'))
{
    $userConfig = require_once __DIR__ . '/config.user.php';
    if(is_array($userConfig))
    {
        $config = array_merge($config, $userConfig);
    }
}

return $config;
