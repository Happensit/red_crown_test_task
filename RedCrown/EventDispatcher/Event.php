<?php

namespace RedCrown\EventDispatcher;

/**
 * Class Event
 * @package RedCrown\Event\EventDispatcher
 */
class Event
{
    /**
     * @var bool
     */
    private $propagationStopped = false;

    /**
     * @return bool
     */
    public function isPropagationStopped()
    {
        return $this->propagationStopped;
    }

    /**
     * @return bool
     */
    public function stopPropagation()
    {
       return $this->propagationStopped = true;
    }
}