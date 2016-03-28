<?php

namespace TM\Config\Field;

class Type
{

    public static function number($min = null, $max = null)
    {
        return array(
            'type'  => 'number',
            'min'   => $min,
            'max'   => $max
        );
    }

    public static function string($maxLength = null)
    {
        return array(
            'type'      => 'text',
            'maxLength' => $maxLength
        );
    }

    public static function text($maxLength = null)
    {
        return array(
            'type'      => 'textarea',
            'maxLength' => $maxLength
        );
    }

    public static function email()
    {
        return array(
            'type'  => 'email'
        );
    }

    public static function html()
    {
        return array(
            'type'  => 'html'
        );
    }

    public static function checkbox($checked = false)
    {
        return array(
            'type'    => 'checkbox',
            'checked' => $checked
        );
    }

    public static function select($values)
    {
        return array(
            'type'   => 'selectbox',
            'values' => $values
        );
    }

}