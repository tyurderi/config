<?php

namespace TM\Config\Field;

use TM\Table\Field\Type\TypeInterface;
use TM\Table\Field\Type as FieldType;

class Type
{

    /**
     * @var string
     */
    protected $fieldType;

    /**
     * @var TypeInterface
     */
    protected $databaseType;

    /**
     * @var string
     */
    protected $valueType;

    /**
     * @var array
     */
    protected $data;

    public function __construct($fieldType, $valueType, TypeInterface $databaseType, $data = array())
    {
        $this->fieldType    = $fieldType;
        $this->valueType    = $valueType;
        $this->databaseType = $databaseType;
        $this->data         = $data;
    }

    public function getFieldType()
    {
        return $this->fieldType;
    }

    public function getValueType()
    {
        return $this->valueType;
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
            'type' => $this->fieldType,
            'data' => $this->data
        ));
    }

    public static function number($min = null, $max = null)
    {
        return new self('number', 'integer', FieldType::int(11), array(
            'min'   => $min,
            'max'   => $max
        ));
    }

    public static function string($maxLength = 255)
    {
        return new self('text', 'string', FieldType::varChar($maxLength), array(
            'maxLength' => $maxLength
        ));
    }

    public static function text($maxLength = null)
    {
        return new self('textarea', 'string', FieldType::text(), array(
            'maxLength' => $maxLength
        ));
    }

    public static function email()
    {
        return new self('email', 'string', FieldType::varChar(255));
    }

    public static function html()
    {
        return new self('html', 'string', FieldType::mediumText());
    }

    public static function checkbox($checked = false)
    {
        return new self('checkbox', 'boolean', FieldType::tinyInt(2), array(
            'checked'   => $checked
        ));
    }

    public static function select($values)
    {
        return new self('select', 'string', FieldType::varChar(32), array(
            'values'    => $values
        ));
    }

}