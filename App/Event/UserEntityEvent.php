<?php

namespace App\Event;

use RedCrown\Database\Database;
use RedCrown\Database\Entity;
use RedCrown\EventDispatcher\Event;

/**
 * Class UserEntityEvent
 * @package App\Event
 */
class UserEntityEvent extends Event
{
    /**
     * Проверяем существование таблицы
     */
    const CHECK_TABLE = 'user.entity.checkTable';

    /**
     *  Импортируем данные
     */
    const IMPORT_DATA = 'user.entity.importDataIntoTable';

    /**
     *  Обновляем статус записи
     */
    const UPDATE_STATUS = 'user.entity.userUpdateStatus';

    /**
     * @var Entity
     */
    private $entity;
    /**
     * @var Database
     */
    private $db;

    /**
     * UserEntityEvent constructor.
     * @param Entity $entity
     * @param Database $db
     */
    public function __construct(Entity $entity, Database $db)
    {
        $this->entity = $entity;
        $this->db = $db;
    }

    /**
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @return Database
     */
    public function getDb()
    {
        return $this->db;
    }
}
