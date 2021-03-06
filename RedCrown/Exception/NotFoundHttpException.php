<?php

namespace RedCrown\Exception;

/**
 * Class HttpException
 * @package RedCrown\Http
 */
class NotFoundHttpException extends \Exception implements RedCrownExceptionInterface
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * NotFoundHttpException constructor.
     * @param null $message
     * @param int $statusCode
     */
    public function __construct($message = null, $statusCode = 404)
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
