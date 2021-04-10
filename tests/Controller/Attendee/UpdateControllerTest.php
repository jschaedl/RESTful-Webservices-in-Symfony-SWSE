<?php

declare(strict_types=1);

namespace App\Tests\Controller\Attendee;

use App\Entity\Attendee;
use App\Repository\AttendeeRepository;
use App\Tests\ApiTestCase;

class UpdateControllerTest extends ApiTestCase
{
    public function test_it_should_update_an_attendee(): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/update_attendee.yaml',
        ]);

        $this->browser->request('PUT', '/attendees/b38aa3e4-f9de-4dca-aaeb-3ec36a9feb6c', [], [], [],
            <<<'EOT'
{
    "firstname": "Paul",
	"lastname": "Paulsen",
	"email": "paul@paulsen.de"
}
EOT
        );

        static::assertResponseStatusCodeSame(204);

        $attendees = static::$container->get(AttendeeRepository::class)->findAll();
        static:: assertCount(1, $attendees);

        /** @var Attendee $expectedAttendee */
        $expectedAttendee = $attendees[0];
        static::assertSame('Paul', $expectedAttendee->getFirstname());
        static::assertSame('Paulsen', $expectedAttendee->getLastname());
        static::assertSame('paul@paulsen.de', $expectedAttendee->getEmail());
    }
}
