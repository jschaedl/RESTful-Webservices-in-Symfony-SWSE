<?php

declare(strict_types=1);

namespace App\Pagination;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

final class PaginationFactory
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function createPaginatedCollection(string $entityClass, int $page = 1, int $size = 10): PaginatedCollection
    {
        $repository = $this->entityManager->getRepository($entityClass);
        $query = $repository->createQueryBuilder('u')->getQuery();

        $paginator = new Paginator($query);
        $total = count($paginator);

        $paginator
            ->getQuery()
            ->setFirstResult($size * ($page - 1))
            ->setMaxResults($size);

        return new PaginatedCollection($paginator->getIterator(), $total);
    }
}
