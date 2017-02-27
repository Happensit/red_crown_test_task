<?php

namespace App\Event;

use App\Entity\User;
use RedCrown\EventDispatcher\EventSubscriberInterface;

/**
 * Class UserEventHandler
 * @package App\Event
 */
class UserEventHandler implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            UserEntityEvent::CHECK_TABLE => 'oncheckTable',
            UserEntityEvent::IMPORT_DATA => 'importDataToTable',
            UserEntityEvent::UPDATE_STATUS => 'onUpdateStatus'
        ];
    }

    /**
     * @param UserEntityEvent $event
     * @return bool
     */
    public function oncheckTable(UserEntityEvent $event)
    {
        $sql = sprintf("CREATE TABLE IF NOT EXISTS %s (
                `id` int AUTO_INCREMENT PRIMARY KEY,
                `name` varchar(128) NOT NULL,
                `status` BOOLEAN NOT NULL DEFAULT 0
                ) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci",
            $event->getEntity()->getTableName()
        );

        return $event->getDb()->execute($sql);

    }

    /**
     * Load data from csv file to database if table is empty
     * @param UserEntityEvent $event
     * @return bool
     */
    public function importDataToTable(UserEntityEvent $event)
    {
        $tableName = $event->getEntity()->getTableName();

        if (!$event->getDb()->query("SELECT COUNT(*) FROM {$tableName}")->findCount()) {

            $sql = sprintf(
                "SET SESSION character_set_database = cp1251;
                 LOAD DATA LOCAL INFILE '%s'
                    INTO TABLE %s
                    FIELDS TERMINATED BY ';'
                    LINES TERMINATED BY '\n'
                    IGNORE 1 LINES
                    (@name, `status`) SET `name` = REPLACE(REPLACE(CONVERT(@name USING utf8), '\"', ''), \"'\", '')",
                dirname(getcwd()) . '/data.csv',
                $event->getDb()->normalizeTableName($tableName)
            );

            $event->getDb()->getPdoInstance()->exec($sql);

        }

        return true;

    }

    /**
     * @param User|UserEntityEvent $event
     * @return mixed
     */
    public function onUpdateStatus(UserEntityEvent $event)
    {
        return $event->getDb()->update(
            $event->getEntity()->getTableName(),
            ['status' => $event->getEntity()->getStatus() ? 0 : 1],
            'id=:id',
            [':id' => $event->getEntity()->getId()]
        );
    }

}