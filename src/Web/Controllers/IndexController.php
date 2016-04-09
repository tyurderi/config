<?php

namespace TM\Config\Web\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use TM\Config\Web\ControllerAbstract;

class IndexController extends ControllerAbstract
{

    public function indexAction(Request $request, Response $response)
    {
        return $this->view->pick('index/index')->finish();
    }

}