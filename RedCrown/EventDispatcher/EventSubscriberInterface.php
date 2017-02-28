<?php

namespace RedCrown\EventDispatcher;

/**
 * Interface EventSubscriberInterface
 * @package RedCrown\Event\EventDispatcher
 */
interface EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents();
}
