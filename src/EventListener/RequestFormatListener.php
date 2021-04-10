<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Negotiation\ContentNegotiator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestFormatListener implements EventSubscriberInterface
{
    public function __construct(
        private ContentNegotiator $contentNegotiator
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                ['onKernelRequest', 8],
            ],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        $format = $this->contentNegotiator->getNegotiatedRequestFormat($request->getAcceptableContentTypes());

        $request->setRequestFormat($format);
    }
}
