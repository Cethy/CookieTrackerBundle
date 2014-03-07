<?php

namespace Cethyworks\CookieTrackerBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

use Cethyworks\CookieTrackerBundle\Request\HandlerInterface as RequestHandler;
use Cethyworks\CookieTrackerBundle\Cookie\FactoryInterface as CookieFactory;

class CookieTrackerListener
{
    /**
     * @var RequestHandler
     */
    protected $requestHandler;

    /**
     * @var CookieFactory
     */
    protected $cookieFactory;

    public function __construct(RequestHandler $requestHandler, CookieFactory $cookieFactory)
    {
        $this->requestHandler = $requestHandler;
        $this->cookieFactory  = $cookieFactory;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType())
        {
            return;
        }

        $request = $event->getRequest();
        $response = $event->getResponse();

        if(! $this->requestHandler->isEligible($request))
        {
            return;
        }

        $response->headers->setCookie($this->cookieFactory->generate($request));
        $event->setResponse($response);
    }
}