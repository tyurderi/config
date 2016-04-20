<?php

namespace TM\Config\Web\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use TM\Config\Components\Querier;
use TM\Config\Web\ControllerAbstract;

class ConfigController extends ControllerAbstract
{

    public function createQuerier(Request $request, Response $response)
    {
        $querier = new Querier($request, $response);
        $querier->setDefaultQuery('config');

        $querier->add('config', function($configId) {
            return $this->app->Modules()->DB()->from('config', $configId)->fetch();
        });

        $querier->add('columns', function($configId) {
            $sql = $this->app->Modules()->DB()->from('config_field cf');

            $sql->select(null)
                ->select('cf.id, cf.label, cf.name')
                ->leftJoin('config_column cc ON cc.config_id = cf.id')
                ->where('cc.id IS NOT NULL')
                ->where('cf.config_id', $configId);

            return $sql->fetchAll();
        });

        $querier->add('fields', function($configId) {
            return $this->app->Modules()->DB()->from('config_field')->where('config_id', $configId)->fetchAll();
        });

        return $querier;
    }

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
        $querier  = $this->createQuerier($request, $response);

        return $this->json->success($querier->execute($configId));
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

        $querier  = $this->createQuerier($request, $response);
        $config   = $querier->query('config', array($configId));
        $columns  = $querier->query('columns', array($configId));

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
    public function deleteAction(Request $request, Response $response)
    {
        $configId = (int) $request->getParam('id');
        $rowId    = (int) $request->getParam('rowId');
        $querier  = $this->createQuerier($request, $response);

        if($config = $querier->query('config', array($configId)))
        {
            $this->app->Modules()->DB()->delete($config['name'], $rowId)->execute();

            return $this->json->success();
        }

        return $this->json->failure();
    }

    /**
     * Action to create or save configuration table rows.
     *
     * @pattern /config/save
     * @method  GET
     *
     * @param $request  Request
     * @param $response Response
     *
     * @return string
     */
    public function saveAction(Request $request, Response $response)
    {
        $configId = (int) $request->getParam('id');
        $rowId    = (int) $request->getParam('rowId');
        $data     = $request->getParam('data');
        $querier  = $this->createQuerier($request, $response);

        if($config = $querier->query('config', array($configId)))
        {
            $fields    = $querier->query('fields', array($configId));
            $values    = array();
            $tableName = $config['name'];

            foreach($fields as $field)
            {
                $fieldName = $field['name'];
                if(isset($data[$fieldName]))
                {
                    $values[$fieldName] = $data[$fieldName];
                }
            }

            if($this->app->Modules()->DB()->from($tableName, $rowId))
            {
                $this->app->Modules()->DB()->update($tableName, $values, $rowId);
            }
            else
            {
                $this->app->Modules()->DB()->insert($tableName, $values);
            }

            return $this->json->success();
        }

        return $this->json->failure();
    }

}