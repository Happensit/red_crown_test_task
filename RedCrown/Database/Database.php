<?php

namespace RedCrown\Database;


use PDO;
use RedCrown\Exception\DatabaseException;

/**
 * Class Database working only for pgsql, mysql, mysqli
 * @package RedCrown\Database
 *
 * @todo Не надо так o_0
 *
 */
class Database
{
    /**
     * @var string
     */
    protected $dsn = '';

    /**
     * @var string
     */
    protected $username = '';

    /**
     * @var string
     */
    protected $password = '';

    /**
     * @var string
     */
    protected $tablePrefix = '4yu_';

    /**
     * @var Database
     */
    private $_pdo;

    /**
     * @var
     */
    private $_statement;

    /**
     * Connection constructor.
     * @param $dsn
     * @param $username
     * @param $password
     * @param $tablePrefix
     */
    public function __construct($dsn, $username, $password, $tablePrefix)
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->tablePrefix = $tablePrefix;
    }

    /**
     * @return PDO
     * @throws DatabaseException
     */
    private function createPdoInstance()
    {

        try {
            $this->_pdo = new PDO(
                $this->dsn, $this->username, $this->password, [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET lc_time_names='ru_RU', NAMES utf8",
                    PDO::MYSQL_ATTR_LOCAL_INFILE => true
                ]
            );

            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            throw new DatabaseException("Database connection could not be established. ;( Reason: " . $e->getMessage());
        }
        
    }

    /**
     * @return Database
     */
    public function getPdoInstance()
    {
        if (!isset($this->_pdo)) {
            $this->createPdoInstance();
        }

        return $this->_pdo;
    }

    /**
     * @param $sql
     * @param array $params
     * @return $this
     */
    public function query($sql, $params = [])
    {
        $this->prepare($sql);
        $this->_statement->execute($params);

        return $this;
    }

    /**
     * @param $className
     * @return mixed
     */
    public function findOne($className)
    {
        $this->_statement->setFetchMode(PDO::FETCH_CLASS, $className);
        return $this->_statement->fetch();
    }

    /**
     * @param $className
     * @return array|false
     */
    public function findAll($className)
    {
        return $this->_statement->fetchAll(PDO::FETCH_CLASS, $className);
    }

    /**
     * @return mixed
     */
    public function findCount()
    {
        return $this->_statement->fetchColumn();
    }

    /**
     * update('{{user}}', ['status'=>1], 'id=:id', [':id'=>2]);
     * @param $table
     * @param $columns
     * @param string $conditions
     * @param array $params
     * @return mixed
     */
    public function update($table, $columns, $conditions = '', $params = [])
    {
        $lines = array();

        foreach ($columns as $name => $value) {
            $lines[] = $name . '=:' . $name;
            $params[':' . $name] = $value;

        }

        $sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $lines);
        $sql .= ' WHERE ' . $conditions;

        return $this->execute($sql, $params);
    }

    /**
     * @param $sql
     * @param array $params
     * @return bool
     */
    public function execute($sql, $params = [])
    {
        $this->prepare($sql);
        $this->_statement->execute($params);
        $rowCount = $this->_statement->rowCount();
        $this->_statement->closeCursor();
        $this->_statement = null;
        return $rowCount;
    }

    /**
     * Get PDO statement
     */
    private function prepare($sql)
    {
        try {
            $this->_statement = $this->getPdoInstance()->prepare($this->normalizeTableName($sql));
        } catch (\PDOException $e) {
            throw new DatabaseException($e->getMessage());
        }

        return $this->_statement;
    }

    /**
     * @param $sql
     * @return mixed
     */
    public function normalizeTableName($sql)
    {
        $sql = preg_replace('/{{(.*?)}}/', $this->getTablePrefix() . '\1', $sql);

        return $sql;
    }

    /**
     * @return string
     */
    public function getTablePrefix()
    {
        return $this->tablePrefix;
    }

    /**
     * @param string $tablePrefix
     */
    public function setTablePrefix($tablePrefix)
    {
        $this->tablePrefix = $tablePrefix;
    }


}