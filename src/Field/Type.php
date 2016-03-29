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
     * @var array
     */
    protected $data;

    public function __construct($fieldType, TypeInterface $databaseType, $data = array())
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
            'type' => $this->fieldType,
            'data' => $this->data
        ));
    }

    public static function number($min = null, $max = null)
    {
        return new self('number', FieldType::int(11), array(
            'min'   => $min,
            'max'   => $max
        ));
    }

    public static function string($maxLength = 255)
    {
        return new self('text', FieldType::varChar($maxLength), array(
            'maxLength' => $maxLength
        ));
    }

    public static function text($maxLength = null)
    {
        return new self('textarea', FieldType::text(), array(
            'maxLength' => $maxLength
        ));
    }

    public static function email()
    {
        return new self('email', FieldType::varChar(255));
    }

    public static function html()
    {
        return new self('html', FieldType::mediumText());
    }

    public static function checkbox($checked = false)
    {
        return new self('checkbox', FieldType::tinyInt(2), array(
            'checked'   => $checked
        ));
    }

    public static function select($values)
    {
        return new self('select', FieldType::varChar(32), array(
            'values'    => $values
        ));
    }

}