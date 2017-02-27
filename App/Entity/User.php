<?php

namespace App\Entity;

use RedCrown\Database\Entity;

/**
 * Class User
 * @package App\Entity
 */
class User extends Entity
{

    /**
     * User statuses constants
     */
    const USER_ACTIVE = 1;
    const USER_INACTIVE = 0;

    /**
     * Class properties
     */
    private $id, $name, $status;

    /**
     * @return string
     */
    public function getTableName()
    {
        return '{{user}}';
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get User status name
     */
    public function getStatusName()
    {
        $statuses = [
            self::USER_ACTIVE => 'Активный пользователь',
            self::USER_INACTIVE => 'Неактивный пользователь'
        ];

        return $statuses[$this->status] ?: null;

    }
}