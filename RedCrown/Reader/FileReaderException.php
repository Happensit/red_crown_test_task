<?php

namespace RedCrown\Reader;

use RedCrown\Exception\RedCrownExceptionInterface;

/**
 * Class FileReaderException
 * @package RedCrown\Reader
 */
class FileReaderException extends \Exception implements RedCrownExceptionInterface
{
    private $statusCode;

    public function __construct($message = null, $statusCode = 500)
{
    $this->statusCode = $statusCode;

    parent::__construct($message);
}

    public function getStatusCode()
{
    return $this->statusCode;
}

}