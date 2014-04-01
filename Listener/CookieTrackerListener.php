<?php

namespace Cethyworks\CookieTrackerBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

use Cethyworks\CookieTrackerBundle\Request\HandlerInterface as RequestHandler;
use Cethyworks\CookieTrackerBundle\Cookie\FactoryInterface as CookieFactory;

use Cethyworks\CookieTrackerBundle\Event\EventHandlerInterface;
use Cethyworks\CookieTrackerBundle\CookieTrackerEvents;
use Cethyworks\CookieTrackerBundle\Event\CookieTrackerEvent;

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

    /**
     * @var EventHandlerInterface
     */
    protected $eventHanlder;

    public function __construct(RequestHandler $requestHandler, CookieFactory $cookieFactory, EventHandlerInterface $eventHandler = null)
    {
        $this->requestHandler = $requestHandler;
        $this->cookieFactory  = $cookieFactory;

        $this->eventHanlder = $eventHandler;
    }

    public function onKernelResponse(FilterResponseEvent $originEvent)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $originEvent->getRequestType())
        {
            return;
        }

        $request = $originEvent->getRequest();
        $response = $originEvent->getResponse();

        if(! $this->requestHandler->isEligible($request))
        {
            return;
        }

        $cookie = $this->cookieFactory->generate($request);

        if($this->eventHanlder instanceof EventHandlerInterface)
        {
            $this->eventHanlder->throwEvent($cookie);
        }

        $response->headers->setCookie($cookie);
        $originEvent->setResponse($response);
    }
}