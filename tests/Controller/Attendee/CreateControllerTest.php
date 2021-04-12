<?php

declare(strict_types=1);

namespace App\Tests\Controller\Attendee;

use App\Entity\Attendee;
use App\Repository\AttendeeRepository;
use App\Tests\ApiTestCase;

class CreateControllerTest extends ApiTestCase
{
    public function test_it_should_create_an_attendee(): void
    {
        $this->browser->request('POST', '/attendees', [], [], [
                'HTTP_Authorization' => 'Bearer '.$this->getUserToken(),
            ],
            <<<'EOT'
{
    "firstname": "Paul",
	"lastname": "Paulsen",
	"email": "paul@paulsen.de"
}
EOT
        );

        static::assertResponseStatusCodeSame(201);
        static::assertResponseHasHeader('Location');

        $attendees = static::$container->get(AttendeeRepository::class)->findAll();
        static:: assertCount(1, $attendees);

        /** @var Attendee $expectedAttendee */
        $expectedAttendee = $attendees[0];
        static::assertSame('Paul', $expectedAttendee->getFirstname());
        static::assertSame('Paulsen', $expectedAttendee->getLastname());
        static::assertSame('paul@paulsen.de', $expectedAttendee->getEmail());
    }
}
