<?php

namespace RedCrown\Database;

use RedCrown\Exception\ConfigureApplicationException;
use RedCrown\Exception\NotFoundHttpException;

/**
 * Class Repository
 * @package RedCrown\Database
 */
abstract class Repository implements RepositoryInterface
{
    /**
     * @var Database
     */
    private $db;

    /**
     * @var Entity
     */
    private $entityClass;

    /**
     * @return mixed
     */
    abstract public function getEntityClass();

    /**
     * Repository constructor.
     * @param Database $db
     * @throws ConfigureApplicationException
     */
    public function __construct(Database $db)
    {
        if (empty($this->getEntityClass())) {
            throw new ConfigureApplicationException('EntityClass is not defined.');
        }

        $this->db = $db;
        $this->entityClass = $this->getEntityClass();
    }

    /**
     * @return Database
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param int $conditions
     * @param array $params
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function findOne($conditions = 1, $params = [])
    {
        $conditions = sprintf('SELECT * FROM %s WHERE %s', $this->entityClass->getTableName(), $conditions);

        if (!$result = $this->db->query($conditions, $params)->findOne($this->entityClass)) {
            throw new NotFoundHttpException(sprintf("%s not Found", get_class($this->entityClass)));
        }

        return $result;

    }

    /**
     * @param int $conditions
     * @param array $params
     * @return array|false
     * @throws NotFoundHttpException
     */
    public function findAll($conditions = 1, $params = [])
    {
        $conditions = sprintf("SELECT * FROM %s WHERE %s", $this->entityClass->getTableName(), $conditions);

        if (!$result = $this->db->query($conditions, $params)->findAll($this->entityClass)) {
            throw new NotFoundHttpException(sprintf("%s not Found", get_class($this->entityClass)));
        }

        return $result;

    }
}
