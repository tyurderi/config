<?php

namespace TM\Config\Components;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class Querier
 *
 * This package is designed to work with a client side script to fetch associated data.
 *
 * @package TM\Config\Components
 */
class Querier
{

    protected $request;

    protected $response;

    protected $queries;

    protected $defaultQuery;

    public function __construct(Request $request, Response $response)
    {
        $this->request  = $request;
        $this->response = $response;
        $this->queries  = array();
    }

    public function setDefaultQuery($name)
    {
        $this->defaultQuery = $name;
    }

    public function add($name, \Closure $closure)
    {
        $this->queries[$name] = $closure;
    }

    public function execute($arguments)
    {
        $only = $this->request->getParam('only', '');
        $with = $this->request->getParam('with', array());
        $data = array();

        if(!empty($only))
        {
            $data[$only] = $this->query($only, func_get_args());
        }
        else
        {
            foreach($with as $key)
            {
                $data[$key] = $this->query($key, func_get_args());
            }
        }

        if(!empty($this->defaultQuery) && empty($only))
        {
            $data[$this->defaultQuery] = $this->query($this->defaultQuery, func_get_args());
        }

        return $data;
    }

    public function query($key, $arguments = array())
    {
        if(isset($this->queries[$key]))
        {
            return call_user_func_array($this->queries[$key], $arguments);
        }

        return array();
    }

}