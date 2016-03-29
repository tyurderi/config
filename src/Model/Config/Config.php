<?php

namespace TM\Config\Model\Config;

class Config
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $parentId;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $name;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

}