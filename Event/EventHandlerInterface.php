<?php

namespace Cethyworks\CookieTrackerBundle\Event;

use Symfony\Component\HttpFoundation\Cookie;

interface EventHandlerInterface
{
    public function throwEvent(Cookie $cookie);
}
