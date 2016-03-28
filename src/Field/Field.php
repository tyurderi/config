<?php

namespace TM\Config\Field;

class Field
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var array
     */
    protected $type;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

}