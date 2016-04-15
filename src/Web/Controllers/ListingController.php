<?php

namespace TM\Config\Web\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use TM\Config\Web\ControllerAbstract;

class ListingController extends ControllerAbstract
{

    /**
     * Action to load items for the overview.
     *
     * @pattern /listing
     * @method  GET
     *
     * @param $request  Request
     * @param $response Response
     *
     * @return string
     */
    public function indexAction(Request $request, Response $response)
    {
        $configId = (int) $request->getParam('id');
        $orderBy  = $request->getParam('orderBy', 'id'); // ORDER BY
        $order    = $request->getParam('order', 'DESC'); //           DESC|ASC
        $filterBy = $request->getParam('filterBy');      // WHERE x LIKE %x%
        $limit    = (int) $request->getParam('limit', 15);
        $offset   = (int) $request->getParam('offset', 0);

        $config   = $this->loadConfig($configId);
        $columns  = $this->loadConfigColumns($configId);

        $sql      = $this->app->Modules()->DB()->from($config['name']);

        $sql->select(null);

        $where = '';
        $params  = '';
        $columnCount = count($columns);
        foreach($columns as $i => $column)
        {
            $sql->select($column['name']);

            if(!empty($filterBy))
            {
                $where .= sprintf('`%s` LIKE ?', $column['name']);
                if($i < $columnCount - 1)
                {
                    $where .= ' OR';
                }

                $param = sprintf('%%%s%%', $filterBy);
                if(!empty($params))
                {
                    $params = array($params);
                    $params[] = $param;
                }
                else
                {
                    $params = $param;
                }
            }
        }

        $sql->where($where, $params)
            ->orderBy(sprintf('%s %s', $orderBy, $order))
            ->limit($limit)
            ->offset($offset);

        $records = $sql->fetchAll();

        return $this->json->success(array(
            'data'  => $records,
            'count' => count($records),
            'total' => $sql->count()
        ));
    }

    /**
     * Action to load the table (columns) for the specified configuration.
     *
     * @pattern /listing/columns
     * @method  GET
     *
     * @param $request  Request
     * @param $response Response
     *
     * @return string
     */
    public function columnsAction(Request $request, Response $response)
    {
        $configId = (int) $request->getParam('id');

        return $this->json->success(array(
            'data'  => $this->loadConfigColumns($configId)
        ));
    }

    protected function loadConfig($configId)
    {
        return $this->app->Modules()->DB()->from('config', $configId)->fetch();
    }

    protected function loadConfigColumns($configId)
    {
        $sql = $this->app->Modules()->DB()->from('config_field cf');

        $sql->select(null)
            ->select('cf.id, cf.label, cf.name')
            ->leftJoin('config_column cc ON cc.config_id = cf.id')
            ->where('cc.id IS NOT NULL')
            ->where('cf.config_id', $configId);

        return $sql->fetchAll();
    }

}