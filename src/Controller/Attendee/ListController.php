<?php

declare(strict_types=1);

namespace App\Controller\Attendee;

use App\Entity\Attendee;
use App\Negotiation\ContentNegotiator;
use App\Pagination\PaginationFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/attendees', name: 'list_attendee', methods: ['GET'])]
final class ListController
{
    public function __construct(
        private PaginationFactory $paginationFactory,
        private SerializerInterface $serializer,
        private ContentNegotiator $contentNegotiator,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $attendeeCollection = $this->paginationFactory->createPaginatedCollection(
            Attendee::class,
            $request->query->getInt('page', 1),
            $request->query->getInt('size', 10),
            'list_attendee'
        );

        $serializedAttendeeCollection = $this->serializer->serialize($attendeeCollection, $request->getRequestFormat());

        return new Response($serializedAttendeeCollection, Response::HTTP_OK, [
            'Content-Type' => $this->contentNegotiator->getNegotiatedContentType(),
        ]);
    }
}
