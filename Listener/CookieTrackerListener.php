<?php

namespace Cethyworks\CookieTrackerBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

use Cethyworks\CookieTrackerBundle\Request\HandlerInterface as RequestHandler;
use Cethyworks\CookieTrackerBundle\Cookie\FactoryInterface as CookieFactory;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function __construct(RequestHandler $requestHandler, CookieFactory $cookieFactory, EventDispatcherInterface $eventDispatcher)
    {
        $this->requestHandler = $requestHandler;
        $this->cookieFactory  = $cookieFactory;

        $this->eventDispatcher = $eventDispatcher;
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

        $event = new CookieTrackerEvent($cookie);
        $this->eventDispatcher->dispatch(CookieTrackerEvents::VISIT, $event);

        $response->headers->setCookie($cookie);
        $originEvent->setResponse($response);
    }
}