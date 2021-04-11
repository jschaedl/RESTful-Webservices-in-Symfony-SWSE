<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Domain\Exception\AttendeeAlreadyAttendsOtherWorkshopOnThatDateException;
use App\Domain\Exception\AttendeeLimitReachedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
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

        if (!($throwable instanceof ValidationFailedException || $throwable instanceof AttendeeAlreadyAttendsOtherWorkshopOnThatDateException || $throwable instanceof AttendeeLimitReachedException)) {
            return;
        }

        if ($throwable instanceof ValidationFailedException) {
            $errors = $this->handleConstraintViolations($throwable->getViolations());
        }

        if ($throwable instanceof AttendeeAlreadyAttendsOtherWorkshopOnThatDateException) {
            $errors = [
                'errors' => [
                    [
                        'message' => 'Attendee already attends other workshop.',
                    ],
                ],
            ];
        }

        if ($throwable instanceof AttendeeLimitReachedException) {
            $errors = [
                'errors' => [
                    [
                        'message' => 'Attendee limit reached.',
                    ],
                ],
            ];
        }

        $serializedErrors = $this->serializer->serialize($errors, $event->getRequest()->getRequestFormat());

        $event->setResponse(
            new Response($serializedErrors, Response::HTTP_BAD_REQUEST)
        );
    }

    private function handleConstraintViolations(ConstraintViolationListInterface $constraintViolationList): array
    {
        $errors = [];
        foreach ($constraintViolationList as $violation) {
            /* @var ConstraintViolationInterface $violation */
            $errors['errors'][] = [
                'message' => 'Validation failed.',
                'detail' => $violation->getPropertyPath().': '.$violation->getMessage(),
            ];
        }

        return $errors;
    }
}
