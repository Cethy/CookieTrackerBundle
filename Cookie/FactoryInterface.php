<?php

namespace Cethyworks\CookieTrackerBundle\Cookie;

use Symfony\Component\HttpFoundation\Cookie;

interface FactoryInterface
{
    /**
     * @abstract
     * @return Cookie
     */
    public function generate();
}
