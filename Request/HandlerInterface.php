<?php

namespace Cethyworks\CookieTrackerBundle\Request;

use Symfony\Component\HttpFoundation\Request;

interface HandlerInterface
{
    /**
     * @abstract
     * @return boolean
     */
    public function isEligible();
}
