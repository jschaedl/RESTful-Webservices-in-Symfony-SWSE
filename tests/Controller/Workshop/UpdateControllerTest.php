<?php

declare(strict_types=1);

namespace App\Tests\Controller\Workshop;

use App\Entity\Workshop;
use App\Repository\WorkshopRepository;
use App\Tests\ApiTestCase;

class UpdateControllerTest extends ApiTestCase
{
    public function test_it_should_update_a_workshop(): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/update_workshop.yaml',
        ]);

        $this->browser->request('PUT', '/workshops/b0b9f18a-464f-4a29-92f9-01f385dd780d', [], [], [],
            <<<'EOT'
{
    "title": "Test Workshop",
	"workshop_date": "2019-09-26"
}
EOT
        );

        static::assertResponseStatusCodeSame(204);

        $workshops = static::$container->get(WorkshopRepository::class)->findAll();
        static:: assertCount(1, $workshops);

        /** @var Workshop $expectedWorkshop */
        $expectedWorkshop = $workshops[0];
        static::assertSame('Test Workshop', $expectedWorkshop->getTitle());
        static::assertSame('2019-09-26', $expectedWorkshop->getWorkshopDate()->format('Y-m-d'));
    }
}
