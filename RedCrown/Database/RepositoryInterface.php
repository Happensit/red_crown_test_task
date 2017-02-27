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
    function getEntityClass();

    /**
     * @param $conditions
     * @param array $params
     * @return mixed
     */
    function findOne($conditions, $params = []);

    /**
     * @param $conditions
     * @param array $params
     * @return mixed
     */
    function findAll($conditions, $params = []);

}
