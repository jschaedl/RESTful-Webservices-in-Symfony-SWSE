<?php

declare(strict_types=1);

namespace App\Tests\Controller\Attendee;

use App\Repository\AttendeeRepository;
use App\Tests\ApiTestCase;

class DeleteControllerTest extends ApiTestCase
{
    public function test_it_should_delete_an_attendee(): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/delete_attendee.yaml',
        ]);

        static::assertNotNull(
            static::$container->get(AttendeeRepository::class)->findOneByIdentifier('b38ab2cf-9f41-4e42-9441-37da67721eac')
        );

        $this->browser->request('DELETE', '/attendees/b38ab2cf-9f41-4e42-9441-37da67721eac', [], [], [
            'HTTP_Authorization' => 'Bearer '.$this->getAdminToken(),
        ]);

        static::assertNull(
            static::$container->get(AttendeeRepository::class)->findOneByIdentifier('b38ab2cf-9f41-4e42-9441-37da67721eac')
        );
    }
}
