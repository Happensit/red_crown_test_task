<?php

namespace RedCrown\Exception;

use RedCrown\EventDispatcher\EventSubscriberInterface;
use RedCrown\Http\HttpEvent;

/**
 * Class ExceptionEventHandler
 * @package RedCrown\Exception
 */
class ExceptionEventHandler implements EventSubscriberInterface
{

    const EXCEPTION = 'kernel.onException';

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            self::EXCEPTION => 'onKernelException'
        ];
    }

    /**
     * @param HttpEvent $event
     * @return mixed
     */
    public function onKernelException(HttpEvent $event)
    {
        return call_user_func(
            $event->getErrorCallback(),
            $event->getException()
        );
    }
}