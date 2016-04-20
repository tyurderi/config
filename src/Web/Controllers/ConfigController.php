<?php

namespace TM\Config\Web\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use TM\Config\Web\ControllerAbstract;

class ConfigController extends ControllerAbstract
{

    /**
     * Loads basic config data. Optionally with config columns and fields.
     *
     * @pattern /config/load
     * @method  GET
     *
     * @param Request  $request
     * @param Response $response
     *
     * @return string
     */
    public function loadAction(Request $request, Response $response)
    {
        $configId = (int) $request->getParam('id');
        $with     = $request->getParam('with', array());
        $only     = $request->getParam('only', array());

        if(!empty($only))
        {
            $data = array();
            if($only === 'config')
            {
                $data[$only] = $this->loadConfig($configId);
            }
            else if($only === 'columns')
            {
                $data[$only] = $this->loadColumns($configId);
            }
            else if($only === 'fields')
            {
                $data[$only] = $this->loadFields($configId);
            }

            return $this->json->success($data);
        }

        if($config = $this->loadConfig($configId))
        {
            $data = array('config' => $config);

            if(in_array('columns', $with))
            {
                $data['columns'] = $this->loadColumns($configId);
            }

            if(in_array('fields', $with))
            {
                $data['fields'] = $this->loadFields($configId);
            }

            return $this->json->success($data);
        }

        return $this->json->failure();
    }

    protected function loadConfig($configId)
    {
        return $this->app->Modules()->DB()->from('config', $configId)->fetch();
    }

    protected function loadColumns($configId)
    {
        $sql = $this->app->Modules()->DB()->from('config_field cf');

        $sql->select(null)
            ->select('cf.id, cf.label, cf.name')
            ->leftJoin('config_column cc ON cc.config_id = cf.id')
            ->where('cc.id IS NOT NULL')
            ->where('cf.config_id', $configId);

        return $sql->fetchAll();
    }

    protected function loadFields($configId)
    {
        return $this->app->Modules()->DB()->from('config_field')->where('config_id', $configId)->fetchAll();
    }

    /**
     * Action for filtering/listing configurations.
     *
     * @pattern /config/search
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

    /**
     * Action to load items for the overview.
     *
     * @pattern /config/fetch
     * @method  GET
     *
     * @param $request  Request
     * @param $response Response
     *
     * @return string
     */
    public function fetchAction(Request $request, Response $response)
    {
        $configId = (int) $request->getParam('id');
        $orderBy  = $request->getParam('orderBy', 'id'); // ORDER BY
        $order    = $request->getParam('order', 'DESC'); //           DESC|ASC
        $filterBy = $request->getParam('filterBy');      // WHERE x LIKE %x%
        $limit    = (int) $request->getParam('limit', 15);
        $offset   = (int) $request->getParam('offset', 0);

        $config   = $this->loadConfig($configId);
        $columns  = $this->loadColumns($configId);

        $sql      = $this->app->Modules()->DB()->from($config['name']);

        $sql->select(null)
            ->select('id');

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
     * Action to remove a row from a configurations table.
     *
     * @pattern /config/fetch
     * @method  GET
     *
     * @param $request  Request
     * @param $response Response
     *
     * @return string
     */
    protected function deleteAction(Request $request, Response $response)
    {
        $configId = (int) $request->getParam('id');
        $rowId    = (int) $request->getParam('rowId');

        if($config = $this->loadConfig($configId))
        {
            $this->app->Modules()->DB()->delete($config['name'], $rowId)->execute();

            return $this->json->success();
        }

        return $this->json->failure();
    }

}