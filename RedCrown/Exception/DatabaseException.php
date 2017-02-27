<?php

namespace RedCrown\Exception;

/**
 * Class DatabaseException
 * @package RedCrown\Database
 */
class DatabaseException extends \Exception implements RedCrownExceptionInterface
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * DatabaseException constructor.
     * @param null $message
     * @param int $statusCode
     */
    public function __construct($message = null, $statusCode = 500)
    {
        $this->statusCode = $statusCode;

        parent::__construct($message);
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

}