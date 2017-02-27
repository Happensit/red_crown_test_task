<?php

namespace RedCrown\EventDispatcher;

/**
 * Interface EventSubscriberInterface
 * @package RedCrown\Event\EventDispatcher
 */
interface EventSubscriberInterface
{
    public static function getSubscribedEvents();

}