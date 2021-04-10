<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ExceptionListener implements EventSubscriberInterface
{
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if ($throwable instanceof ValidationFailedException) {
            $this->handleValidationFailedException($event);
        }
    }

    private function handleValidationFailedException(ExceptionEvent $event)
    {
        $throwable = $event->getThrowable();

        $errors = [];
        foreach ($throwable->getViolations() as $violation) {
            /* @var ConstraintViolationInterface $violation */
            $errors['errors'][] = [
                'message' => 'Validation failed.',
                'detail' => $violation->getPropertyPath().': '.$violation->getMessage(),
            ];
        }

        $serializedErrors = $this->serializer->serialize($errors, $event->getRequest()->getRequestFormat());

        $event->setResponse(
            new Response($serializedErrors, Response::HTTP_BAD_REQUEST)
        );
    }
}
