<?php

namespace TM\Config\Components\Generator;

use TM\Config\Field\Field;
use TM\Config\Components\ComponentAbstract;
use TM\Table\Field\Type;
use TM\Table\Manager;
use TM\Table\Table;

class TableGenerator extends ComponentAbstract
{

    /**
     * @var Manager
     */
    protected $manager;

    public function initialize()
    {
        $this->manager = new Manager();
    }

    /**
     * Generates a table out of a Configuration fields.
     *
     * @param string  $name
     * @param Field[] $fields
     *
     * @return boolean
     */
    public function generate($name, $fields)
    {
        $table = new Table($name);

        $table->addField('id', Type::int(11))->setAutoIncrement(true)->setPrimaryKey(true);

        foreach($fields as $field)
        {
            $table->addField($field->getName(), $field->getType()->getDatabaseType());
        }

        $query = $this->manager->createQuery($table);

        return $this->DB()->query($query)->execute();
    }

    public function drop($name)
    {
        $query = 'DROP TABLE IF EXISTS `' . $name . '`';

        return $this->DB()->query($query)->execute();
    }

}