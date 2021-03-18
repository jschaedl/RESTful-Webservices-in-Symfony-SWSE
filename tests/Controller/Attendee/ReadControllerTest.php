<?php

declare(strict_types=1);

namespace App\Tests\Controller\Attendee;

use App\Tests\ApiTestCase;

class ReadControllerTest extends ApiTestCase
{
    public function test_it_should_requested_attendee(): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/read_attendee.yaml',
        ]);

        $this->browser->request('GET', '/attendees/470eefeb-6847-4098-9b6c-14be8e09a82e');

        static::assertResponseIsSuccessful();

        $this->assertMatchesJsonSnapshot($this->browser->getResponse()->getContent());
    }
}
