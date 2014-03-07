<?php

namespace Cethyworks\CookieTrackerBundle\Cookie;

use Symfony\Component\HttpFoundation\Cookie;
use Cethyworks\CookieTrackerBundle\Request\SimpleHandler;

class SimpleFactory implements FactoryInterface
{
    /**
     * @var array
     */
    protected $cookieParameters = array(
        'name'     => '',
        'value'    => '',
        'expire'   => 0,

        'path'     => '/',
        'domain'   => null,
        'secure'   => false,
        'httpOnly' => true
    );

    /**
     * @var SimpleHandler
     */
    protected $request;

    /**
     * @param string  $cookieName
     * @param integer $cookieExpire (in days)
     */
    public function __construct($cookieName, $cookieExpire, SimpleHandler $handler)
    {
        $this->cookieParameters['name']   = $cookieName;
        $this->cookieParameters['expire'] = $cookieExpire;

        $this->handler                    = $handler;
    }

    /**
     * @return Cookie
     */
    public function generate()
    {
        $expire = new \DateTime();
        $expire->modify(sprintf('+%dday', $this->cookieParameters['expire']));

        return new Cookie(
            $this->cookieParameters['name'],
            $this->handler->getValue(),
            $expire,
            $this->cookieParameters['path'],
            $this->cookieParameters['domain'],
            $this->cookieParameters['secure'],
            $this->cookieParameters['httpOnly']
        );
    }
}
