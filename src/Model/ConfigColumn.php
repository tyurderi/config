<?php

namespace TM\Config\Model;

class ConfigColumn
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
     * @var integer
     */
    protected $configFieldId;

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

    public function getConfigFieldId()
    {
        return $this->configFieldId;
    }

    public function setConfigFieldId($configFieldId)
    {
        $this->configFieldId = $configFieldId;
    }

}