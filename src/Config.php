<?php

namespace TM\Config;

class Config
{

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var integer
     */
    protected $type;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var array
     */
    protected $columns;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    public function setColumns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    public function addField($name, array $type)
    {
        $field = new Field\Field();
        $field->setName($name);
        $field->setType($type);

        $this->fields[$name] = $field;

        return $field;
    }

    public function getField($name)
    {
        if(isset($this->fields[$name]))
        {
            return $this->fields[$name];
        }

        return null;
    }

}