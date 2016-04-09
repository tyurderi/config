<?php

namespace TM\Config\Model;

use TM\Config\Application;

abstract class ModelAbstract
{

    const PRIMARY_KEY = 'id';

    protected static function getSource()
    {
        throw new \BadMethodCallException();
    }

    public static function find($primaryKey = null)
    {
        $query = self::getQuery();
        if($primaryKey !== null)
        {
            $query = $query->where(static::PRIMARY_KEY, $primaryKey);
        }

        return self::createModel($query->fetch());
    }

    public static function findAll()
    {
        return self::findBy(array());
    }

    public static function findBy(array $criteria)
    {
        $records = self::getQuery()->where($criteria)->fetchAll();
        $models  = array();

        foreach($records as $record)
        {
            $models[] = self::createModel($record);
        }

        return $models;
    }

    private static function createModel($record)
    {
        if(!empty($record))
        {
            $model = new static();

            foreach($record as $name => $value)
            {
                $fieldName  = camelize($name);
                $methodName = 'set' . $fieldName;

                if(method_exists($model, $methodName))
                {
                    $model->{$methodName}($value);
                }
            }

            return $model;
        }

        return false;
    }

    private static function getQuery()
    {
        return Application::getInstance()->Modules()->DB()->from(static::getSource());
    }

}