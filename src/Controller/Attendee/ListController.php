<?php

declare(strict_types=1);

namespace App\Controller\Attendee;

use App\Entity\Attendee;
use App\Negotiation\ContentNegotiator;
use App\Pagination\AttendeeCollection;
use App\Pagination\PaginationFactory;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/attendees', name: 'list_attendee', methods: ['GET'])]
#[IsGranted('IS_AUTHENTICATED_ANONYMOUSLY')]
final class ListController
{
    public function __construct(
        private PaginationFactory $paginationFactory,
        private SerializerInterface $serializer,
        private ContentNegotiator $contentNegotiator,
    ) {
    }

    /**
     * @OA\Get(
     *      tags={"Attendee"},
     *      summary="Returns a paginated collection of attendees.",
     *      description="Returns a paginated collection of attendees.",
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="The field to specify the current page."
     *      ),
     *      @OA\Parameter(
     *          name="size",
     *          in="query",
     *          description="The field to specify the current page size."
     *      ),
     *     @OA\Response(
     *          description="Returns a list of attendees.",
     *          response=200,
     *          @Model(type=App\Pagination\AttendeeCollection::class)
     *      )
     * )
     */
    public function __invoke(Request $request): Response
    {
        $attendeeCollection = $this->paginationFactory->createPaginatedCollection(
            AttendeeCollection::class,
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
