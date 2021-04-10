<?php

declare(strict_types=1);

namespace App\Tests\Controller\Workshop;

use App\Tests\ApiTestCase;

class ReadControllerTest extends ApiTestCase
{
    public function test_it_should_requested_workshop(): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/read_workshop.yaml',
        ]);

        $this->browser->request('GET', '/workshops/42c77031-05d0-4127-af3e-6b2ae62f487c', [], [], ['HTTP_ACCEPT' => 'application/hal+json']);

        static::assertResponseIsSuccessful();

        $this->assertMatchesJsonSnapshot($this->browser->getResponse()->getContent());
    }
}
