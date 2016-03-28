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
     * @var Field\Field[]
     */
    protected $fields;

    /**
     * @var array
     */
    protected $columns;

    /**
     * @var Config
     */
    protected $parent;

    /**
     * @var Config[]
     */
    protected $children;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setColumns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
        $this->parent->addChildren($this);
    }

    public function getParent()
    {
        return $this->parent;
    }

    protected function addChildren(Config $children)
    {
        $this->children[] = $children;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function addField($name, array $type)
    {
        $field = new Field\Field();
        $field->setName($name);
        $field->setLabel(ucfirst($name));
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

    public function getFields()
    {
        return $this->fields;
    }

    public function getType()
    {
        return $this->type;
    }

}