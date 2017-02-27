<?php

namespace RedCrown\Database;

/**
 * Class Entity
 * @package RedCrown\Database
 */
abstract class Entity implements EntityInterface
{
    /**
     * @return string
     */
    abstract public function getTableName();

    /**
     * @return mixed
     */
    abstract public function getId();

    /**
     * @return string
     */
    public function getPrimaryKey()
    {
        return 'id';
    }

    /**
     * Magic getter
     * @param $name
     * @return mixed
     */
    function __get($name)
    {
        $getter = 'get' . ucwords($name, '_');
        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        }

        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    /**
     * Magic setter
     * @param $name
     * @param $value
     * @return mixed
     */
    function __set($name, $value)
    {
        $setter = 'set' . ucwords($name, '_');
        if (method_exists($this, $setter)) {
            return $this->{$setter}($value);
        }
    }

}