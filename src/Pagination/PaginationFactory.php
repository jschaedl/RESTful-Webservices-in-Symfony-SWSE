<?php

declare(strict_types=1);

namespace App\Pagination;

use App\Negotiation\ContentNegotiator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class PaginationFactory
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UrlGeneratorInterface $urlGenerator,
        private ContentNegotiator $contentNegotiator,
    ) {
    }

    public function createPaginatedCollection(
        string $collectionClass,
        string $entityClass,
        int $page,
        int $size,
        string $routeName
    ): PaginatedCollection {
        $repository = $this->entityManager->getRepository($entityClass);
        $query = $repository->createQueryBuilder('u')->getQuery();

        $paginator = new Paginator($query);
        $total = count($paginator);
        $pageCount = ceil($total / $size);

        $paginator
            ->getQuery()
            ->setFirstResult($size * ($page - 1))
            ->setMaxResults($size);

        $paginatedCollection = new $collectionClass($paginator->getIterator(), $total);

        if ($this->contentNegotiator->isNegotiatedContentTypeJsonHal()) {
            $paginatedCollection->addLink('self', $this->urlGenerator->generate($routeName, [
                'page' => $page,
                'size' => $size,
            ]));

            if ($page < $pageCount) {
                $paginatedCollection->addLink('next', $this->urlGenerator->generate($routeName, [
                    'page' => $page + 1,
                    'size' => $size,
                ]));
            }

            if ($page > 1) {
                $paginatedCollection->addLink('prev', $this->urlGenerator->generate($routeName, [
                    'page' => $page - 1,
                    'size' => $size,
                ]));
            }

            $paginatedCollection->addLink('first', $this->urlGenerator->generate($routeName, [
                'page' => 1,
                'size' => $size,
            ]));

            $paginatedCollection->addLink('last', $this->urlGenerator->generate($routeName, [
                'page' => $pageCount,
                'size' => $size,
            ]));
        }

        return $paginatedCollection;
    }
}
