<?php

namespace Framework\Model;

use Framework\DI\Service;

/**
 * Class ActiveRecord
 * @package Framework\Model
 */
abstract class ActiveRecord
{
    /**
     * Primary key
     *
     * @var mixed
     */
    protected static $pk = 'id';

    /**
     * Array of database`s fields
     *
     * @var array
     */
    protected static $fields = array();

    /**
     * Returns model rules
     *
     * @return array
     */
    public function getRules()
    {
        return [];
    }

    /**
     * Get names of database table fields
     *
     * @return array
     */
    public static function getFields()
    {
        if (empty(static::$fields)) {
            $db = Service::get('db');
            $sql = "SHOW FIELDS FROM " . static::getTable();
            $result = $db->query($sql);
            $result = $result->fetchAll();

            foreach ($result as $row) {
                static::$fields[] = $row['Field'];
            }
        }

        return static::$fields;
    }

    /**
     *  Returns table name
     *
     * @return string
     */
    public static function getTable()
    {
        //empty
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        if (preg_match('/^findBy([\w\d_-]+$)/', $name, $matches)) {
            $fields = static::getFields();
            array_walk($fields, function(&$item) {
                $item = strtolower($item);
            });
            $field = strtolower($matches[1]);

            if (array_search($field, $fields)) {
                $db = Service::get('db');
                $sql = 'SELECT * FROM `' . static::getTable() . '` WHERE `'. $field . '` = :' . $field;
                $query = $db->prepare($sql);
                $query->bindValue(":$field", $arguments[0]);
                $query->execute();
                $result = $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());

                return  $result[0];
            }
        }

        return null;
    }

    /**
     * Returns records from table
     *
     * @param string $mode
     * @return mixed
     */
    public static function find($mode = 'all')
    {
        $db = Service::get('db');
        $table = static::getTable();
        $sql = "SELECT * FROM " . $table;

        if ($mode !== 'all') {
            $pk = static::$pk;
            $sql .= " WHERE $pk = :$pk";
            $query = $db->prepare($sql);
            $query->bindParam(":$pk", $mode);
            $query->execute();
        } else {
            $query = $db->query($sql);
        }

        $result = $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());

        return $mode !== 'all' ? $result[0] : $result;
    }

    /**
     * Saves record to table
     *
     * @return mixed
     */
    public function save()
    {
        $values = array();
        $db = Service::get('db');
        $fields = $this->getFields();
        $add_params = function($sql) use ($fields)
        {
            foreach ($fields as $field) {
                $sql .= '`' . $field . '`' . ' = :' . $field . ', ';
        }

            return $sql = substr($sql, 0, -2);
        };
        $sql = 'INSERT INTO `' . static::getTable() . '` SET ';
        $sql = $add_params($sql);
        $sql .= ' ON DUPLICATE KEY UPDATE ';
        $sql = $add_params($sql);

        foreach ($fields as $field) {
            $values[':' . $field] = $this->$field;
        }

        $result = $db->prepare($sql);

        return $result->execute($values);
    }
}
