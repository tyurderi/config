<?php

namespace TM\Config\Field;

class Type
{

    /**
     * @var string
     */
    protected $fieldType;

    /**
     * @var string
     */
    protected $databaseType;

    /**
     * @var array
     */
    protected $data;

    public function __construct($fieldType, $databaseType, $data = array())
    {
        $this->fieldType    = $fieldType;
        $this->databaseType = $databaseType;
        $this->data         = $data;
    }

    public function getFieldType()
    {
        return $this->fieldType;
    }

    public function getDatabaseType()
    {
        return $this->databaseType;
    }

    public function getData()
    {
        return $this->data;
    }

    public function __toString()
    {
        return json_encode(array(
            'field_type'    => $this->fieldType,
            'database_type' => $this->databaseType,
            'data'          => $this->data
        ));
    }

    public static function number($min = null, $max = null)
    {
        return new self('number', 'INT(11)', array(
            'min'   => $min,
            'max'   => $max
        ));
    }

    public static function string($maxLength = 255)
    {
        return new self('text', 'VARCHAR(' . $maxLength . ')', array(
            'maxLength' => $maxLength
        ));
    }

    public static function text($maxLength = null)
    {
        return new self('textarea', 'TEXT', array(
            'maxLength' => $maxLength
        ));
    }

    public static function email()
    {
        return new self('email', 'VARCHAR(255)');
    }

    public static function html()
    {
        return new self('html', 'MEDIUMTEXT');
    }

    public static function checkbox($checked = false)
    {
        return new self('checkbox', 'TINYINT(2)', array(
            'checked'   => $checked
        ));
    }

    public static function select($values)
    {
        return new self('select', 'VARCHAR(32)', array(
            'values'    => $values
        ));
    }

}