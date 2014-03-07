<?php

namespace Cethyworks\CookieTrackerBundle\Request;

use Symfony\Component\HttpFoundation\Request;

class SimpleHandler implements HandlerInterface
{
    /**
     * @var string
     */
    protected $getParameter = '';

    /**
     * @param string $getParameter
     */
    public function __construct($getParameter, Request $request)
    {
        $this->getParameter = $getParameter;
        $this->request      = $request;
    }

    /**
     * @return boolean
     */
    public function isEligible()
    {
        return null !== $this->getValue();
    }

    /**
     * @return string|null
     */
    public function getValue()
    {
        return $this->request->get($this->getParameter, null);
    }
}
