<?php

namespace TM\Config\Components;

use TM\Config\Config;
use TM\Console\Console;

class Manager extends ComponentAbstract
{

    public function initialize()
    {

    }

    public function register(Config $config)
    {
        if($configId = $this->getConfigId($config->getName()))
        {
            $this->synchronizeFields($configId, $config);
        }
        else
        {
            $this->saveConfig($config);
        }

        $tableGenerator = new Generator\TableGenerator($this->app);
        $tableGenerator->generate($config->getName(), $config->getFields());

        $modelGenerator = new Generator\ModelGenerator($this->app);
        $modelGenerator->generate($config);
    }

    protected function synchronizeFields($configId, Config $config)
    {
        $this->DB()->delete('config_column')->where('config_id', $configId)->execute();
        $this->DB()->delete('config_field')->where('config_id', $configId)->execute();
        $this->DB()->delete('config')->where('id', $configId)->execute();

        $this->saveConfig($config);
    }

    protected function getParentId(Config $config)
    {
        if($config->getParent() !== null)
        {
            return $this->getConfigId($config->getParent()->getName());
        }
    }

    protected function saveConfig(Config $config)
    {
        $configId = $this->DB()->insert('config', array(
            'parent_id' => $this->getParentId($config),
            'label'     => $config->getLabel(),
            'name'      => $config->getName()
        ))->execute();

        $fieldIds = array();

        foreach($config->getFields() as $field)
        {
            $fieldId = $this->DB()->insert('config_field', array(
                'config_id'  => $configId,
                'label'      => $field->getLabel(),
                'name'       => $field->getName(),
                'field_type' => (string) $field->getType()
            ))->execute();

            $fieldIds[$field->getName()] = $fieldId;
        }

        foreach($config->getColumns() as $column)
        {
            if(isset($fieldIds[$column]))
            {
                $fieldId = $fieldIds[$column];

                $this->DB()->insert('config_column', array(
                    'config_id'       => $configId,
                    'config_field_id' => $fieldId
                ))->execute();
            }
        }
    }

    protected function getConfigId($name)
    {
        return $this->DB()
            ->from('config')
            ->where('name', $name)
            ->fetch('id');
    }

}