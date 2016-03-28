<?php

namespace TM\Config\Field;

class Type
{

    public static function number($min = null, $max = null)
    {
        return array(
            'field_type' => 'number',
            'type'       => 'INT(11)',
            'min'        => $min,
            'max'        => $max
        );
    }

    public static function string($maxLength = 255)
    {
        return array(
            'field_type' => 'text',
            'type'       => 'VARCHAR(' . $maxLength . ')',
            'maxLength'  => $maxLength
        );
    }

    public static function text($maxLength = null)
    {
        return array(
            'field_type' => 'textarea',
            'type'       => 'TEXT',
            'maxLength'  => $maxLength
        );
    }

    public static function email()
    {
        return array(
            'field_type' => 'email',
            'type'       => 'VARCHAR(255)'
        );
    }

    public static function html()
    {
        return array(
            'field_type' => 'html',
            'type'       => 'MEDIUMTEXT'
        );
    }

    public static function checkbox($checked = false)
    {
        return array(
            'field_type' => 'checkbox',
            'type'       => 'TINYINT(2)',
            'checked'    => $checked
        );
    }

    public static function select($values)
    {
        return array(
            'field_type' => 'selectbox',
            'type'       => 'VARCHAR(32)',
            'values'     => $values
        );
    }

}