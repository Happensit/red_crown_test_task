<?php

namespace RedCrown\Database;

/**
 * Interface RepositoryInterface
 * @package RedCrown\Database
 */
interface RepositoryInterface
{
    /**
     * @return mixed
     */
    public function getEntityClass();

    /**
     * @param $conditions
     * @param array $params
     * @return mixed
     */
    public function findOne($conditions, $params = []);

    /**
     * @param $conditions
     * @param array $params
     * @return mixed
     */
    public function findAll($conditions, $params = []);
}
