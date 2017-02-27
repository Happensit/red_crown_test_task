<?php

namespace RedCrown\Http;

use RedCrown\EventDispatcher\Event;

/**
 * Class HttpEvent
 * @package RedCrown\Http
 */
class HttpEvent extends Event
{
    /**
     * @var \Exception
     */
    private $exception;

    /**
     * @var \Closure
     */
    private $errorCallback;

    /**
     * HttpEvent constructor.
     * @param \Exception $e
     * @param \Closure $errorCallback
     */
    public function __construct(\Exception $e, \Closure $errorCallback)
    {
        $this->exception = $e;
        $this->errorCallback = $errorCallback;
    }

    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @return callable
     */
    public function getErrorCallback()
    {
        return $this->errorCallback;
    }


}