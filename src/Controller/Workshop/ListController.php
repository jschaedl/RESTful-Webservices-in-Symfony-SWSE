<?php

declare(strict_types=1);

namespace App\Controller\Workshop;

use App\Entity\Workshop;
use App\Negotiation\ContentNegotiator;
use App\Pagination\PaginationFactory;
use App\Pagination\WorkshopCollection;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/workshops', name: 'list_workshop', methods: ['GET'])]
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
     *      tags={"Workshop"},
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
     *          @Model(type=App\Pagination\WorkshopCollection::class)
     *      )
     * )
     */
    public function __invoke(Request $request): Response
    {
        $workshopCollection = $this->paginationFactory->createPaginatedCollection(
            WorkshopCollection::class,
            Workshop::class,
            $request->query->getInt('page', 1),
            $request->query->getInt('size', 10),
            'list_workshop'
        );

        $serializedWorkshopCollection = $this->serializer->serialize($workshopCollection, $request->getRequestFormat());

        return new Response($serializedWorkshopCollection, Response::HTTP_OK, [
            'Content-Type' => $this->contentNegotiator->getNegotiatedContentType(),
        ]);
    }
}
