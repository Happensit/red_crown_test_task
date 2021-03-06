<?php

namespace RedCrown\Reader;

use RedCrown\Exception\RedCrownExceptionInterface;

/**
 * Class FileReaderException
 * @package RedCrown\Reader
 */
class FileReaderException extends \Exception implements RedCrownExceptionInterface
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * FileReaderException constructor.
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
