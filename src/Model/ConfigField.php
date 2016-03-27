<?php

namespace TM\Config\Model;

class ConfigField
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $configId;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $fieldType;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getConfigId()
    {
        return $this->configId;
    }

    public function setConfigId($configId)
    {
        $this->configId = $configId;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getFieldType()
    {
        return $this->fieldType;
    }

    public function setFieldType($fieldType)
    {
        $this->fieldType = $fieldType;
    }

}