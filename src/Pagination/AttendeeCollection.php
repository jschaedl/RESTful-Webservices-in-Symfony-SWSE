<?php

declare(strict_types=1);

namespace App\Pagination;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

final class AttendeeCollection extends PaginatedCollection
{
    /**
     * @OA\Property(type="array", @OA\Items(ref=@Model(type=App\Entity\Attendee::class)))
     */
    protected array $items;
}
