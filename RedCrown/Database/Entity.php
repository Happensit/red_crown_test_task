<?php

namespace RedCrown\Database;

use RedCrown\Exception\BadMethodCallException;

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
     * @throws BadMethodCallException
     */
    public function __get($name)
    {
        $getter = 'get' . str_replace('_', '', ucwords($name, '_'));

        if (is_callable([$this, $getter])) {
            return $this->{$getter}();
        }

        throw new BadMethodCallException(sprintf(
            'The option "%s" does not have a callable "%s" getter method which must be defined',
            $name,
            $getter
        ));

    }

    /**
     * Magic setter
     * @param $name
     * @param $value
     * @return mixed
     */
    public function __set($name, $value)
    {
        $setter = 'set' . str_replace('_', '', ucwords($name, '_'));

        if (is_callable([$this, $setter])) {
            $this->{$setter}($value);

            return;
        }

    }
}
