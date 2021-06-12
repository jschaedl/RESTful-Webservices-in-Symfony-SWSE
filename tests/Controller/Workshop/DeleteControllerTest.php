<?php

declare(strict_types=1);

namespace App\Tests\Controller\Workshop;

use App\Repository\WorkshopRepository;
use App\Tests\ApiTestCase;

class DeleteControllerTest extends ApiTestCase
{
    public function test_it_should_delete_a_workshop(): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/delete_workshop.yaml',
        ]);

        static::assertNotNull(
            static::$container->get(WorkshopRepository::class)->findOneByIdentifier('134b4352-bb2b-465e-80a9-462455018db2')
        );

        $this->browser->request('DELETE', '/workshops/134b4352-bb2b-465e-80a9-462455018db2', [], [], [
            'HTTP_Authorization' => 'Bearer '.$this->getAdminToken(),
        ]);

        static::assertNull(
            static::$container->get(WorkshopRepository::class)->findOneByIdentifier('134b4352-bb2b-465e-80a9-462455018db2')
        );
    }
}
