<?php

namespace TM\Config\Components;

class Database extends Component
{

    /**
     * @var \FluentPDO
     */
    protected $db;

    public function initialize()
    {
        $pdo = new \PDO(
            sprintf('mysql:host=%s;dbname=%s',
                $this->app->getConfig('database.host'),
                $this->app->getConfig('database.shem')
            ),
            $this->app->getConfig('database.user'),
            $this->app->getConfig('database.pass')
        );

        $this->db = new \FluentPDO($pdo);
    }

    public function PDO()
    {
        return $this->db->getPdo();
    }

    public function delete($table, $primaryKey = null)
    {
        return $this->db->delete($table, $primaryKey);
    }

    public function insert($table, $values = array())
    {
        return $this->db->insertInto($table, $values);
    }

    public function update($table, $set = array(), $primaryKey = null)
    {
        return $this->db->update($table, $set, $primaryKey);
    }

    public function from($table, $primaryKey = null)
    {
        return $this->db->from($table, $primaryKey);
    }

}