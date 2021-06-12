<?php

declare(strict_types=1);

namespace App\Tests\Controller\Workshop;

use App\Entity\Workshop;
use App\Repository\WorkshopRepository;
use App\Tests\ApiTestCase;

class AddAttendeeToWorkshopControllerTest extends ApiTestCase
{
    public function test_it_should_add_an_attendee_to_a_workshop(): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/add_attendee_to_workshop.yaml',
        ]);

        /** @var Workshop $workshop */
        $workshop = static::$container->get(WorkshopRepository::class)->findOneByIdentifier('c3cd4184-8657-4593-816e-90b229a703c8');
        static::assertCount(0, $workshop->getAttendees());

        $this->browser->request('POST', '/workshops/c3cd4184-8657-4593-816e-90b229a703c8/attendees/add/123d4e99-3e28-4a81-a2bd-295661bf6a15', [], [], []);

        static::assertResponseStatusCodeSame(204);

        /** @var Workshop $workshop */
        $workshop = static::$container->get(WorkshopRepository::class)->findOneByIdentifier('c3cd4184-8657-4593-816e-90b229a703c8');
        static::assertCount(1, $workshop->getAttendees());
    }
}
