<?php

namespace Elao\Bundle\BrowserDetectorBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Elao\BrowserDetector\BrowserDetector;

/**
 * Request Listener
 */
class RequestListener
{
    /**
     * Listener manager
     *
     * @var BrowserDetector
     */
    private $browserDetector;

    /**
     * Constructor
     * @param BrowserDetector $browserDetector The listener manager service
     */
    public function __construct(BrowserDetector $browserDetector)
    {
        $this->browserDetector = $browserDetector;
    }

    /**
     * On Kernel Request
     *
     * @param GetResponseEvent $event
     *
     * @return void
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernel::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }

        $this->browserDetector->setUserAgent($event->getRequest()->headers->get('user-agent'));
    }
}
