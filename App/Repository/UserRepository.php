<?php

namespace App\Repository;

use App\Entity\User;
use App\Event\UserEntityEvent;
use RedCrown\Database\Database;
use RedCrown\Database\Repository;
use RedCrown\EventDispatcher\EventDispatcher;
use RedCrown\Exception\ConfigureApplicationException;
use RedCrown\Exception\NotFoundHttpException;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository extends Repository
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * UserRepository constructor.
     * @param EventDispatcher $eventDispatcher
     * @param Database $db
     */
    public function __construct(EventDispatcher $eventDispatcher, Database $db)
    {
        parent::__construct($db);
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return User
     */
    public function getEntityClass()
    {
        return new User();
    }

    /**
     * Этот метод всегда будет возвращать юзера
     * @return mixed
     * @throws ConfigureApplicationException
     */
    public function findRandom()
    {
        $userEntityEvent = new UserEntityEvent($this->getEntityClass(), $this->getDb());
        if ($this->eventDispatcher->dispatch(UserEntityEvent::CHECK_TABLE, $userEntityEvent)) {
            $sql = sprintf(
                'SELECT u.* FROM %1$s AS u
                          JOIN (SELECT ROUND(RAND()*(SELECT MAX(id) FROM %1$s)) as id) as r
                          WHERE u.id >= r.id
                          LIMIT 1',
                $this->getEntityClass()->getTableName()
            );

            if ($user = $this->getDb()->query($sql)->findOne($this->getEntityClass())) {
                /** $user UserEntity */
                $userEntityEvent =  new UserEntityEvent($user, $this->getDb());
                $this->eventDispatcher->dispatch(UserEntityEvent::UPDATE_STATUS, $userEntityEvent);
            }

            return $user;
        }

        throw new ConfigureApplicationException("Something wrong, the data have not been received");
    }
}
