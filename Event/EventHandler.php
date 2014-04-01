<?php

namespace Cethyworks\CookieTrackerBundle\Event;

use Cethyworks\CookieTrackerBundle\Event\EventHandlerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Cethyworks\CookieTrackerBundle\CookieTrackerEvents;

class EventHandler implements EventHandlerInterface
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Cookie $cookie
     */
    public function throwEvent(Cookie $cookie)
    {
        $event = new CookieTrackerEvent($cookie);
        $this->eventDispatcher->dispatch(CookieTrackerEvents::VISIT, $event);
    }
}
