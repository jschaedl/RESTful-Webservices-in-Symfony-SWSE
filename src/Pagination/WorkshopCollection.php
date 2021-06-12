<?php

declare(strict_types=1);

namespace App\Pagination;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

final class WorkshopCollection extends PaginatedCollection
{
    /**
     * @OA\Property(type="array", @OA\Items(ref=@Model(type=App\Entity\Workshop::class)))
     */
    protected array $items;
}
