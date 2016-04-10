<?php

namespace TM\Config\Web\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use TM\Config\Web\ControllerAbstract;

class IndexController extends ControllerAbstract
{

    /**
     * Index action
     *
     * @pattern /
     * @method  GET
     *
     * @param $request  Request
     * @param $response Response
     *
     * @return string
     */
    public function indexAction(Request $request, Response $response)
    {
        return $this->view->pick('index/index')->finish();
    }

    /**
     * Action for filtering/listing configurations.
     *
     * @pattern /search
     * @method  POST
     *
     * @param $request  Request
     * @param $response Response
     *
     * @return string
     */
    public function searchAction(Request $request, Response $response)
    {
        $input = $request->getParsedBodyParam('input', '');

        $query = $this->app->Modules()->DB()
            ->from('config')
            ->select(null)
            ->select('id, label');

        if(!empty($input))
        {
            $query = $query->where('label LIKE ?', '%' . $input . '%');
        }

        $records = $query->fetchAll();

        return $this->json->success(array(
            'data'  => $records,
            'count' => count($records)
        ));
    }

}