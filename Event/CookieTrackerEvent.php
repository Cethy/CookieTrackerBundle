<?php

namespace Cethyworks\CookieTrackerBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Cookie;

class CookieTrackerEvent extends Event
{
    /**
     * @var Cookie
     */
    protected $cookie;

    /**
     * @var array
     */
    protected $datas;

    public function __construct(Cookie $cookie, array $datas = array())
    {
        $this->cookie = $cookie;
        $this->datas  = $datas;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public function getCookie()
    {
        return $this->cookie;
    }

    /**
     * @return array
     */
    public function getDatas()
    {
        return $this->datas;
    }
}