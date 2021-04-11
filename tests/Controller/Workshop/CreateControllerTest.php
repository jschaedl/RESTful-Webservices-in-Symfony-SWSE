<?php

declare(strict_types=1);

namespace App\Tests\Controller\Workshop;

use App\Entity\Workshop;
use App\Repository\WorkshopRepository;
use App\Tests\ApiTestCase;

class CreateControllerTest extends ApiTestCase
{
    public function test_it_should_create_a_workshop(): void
    {
        $this->browser->request('POST', '/workshops', [], [], [],
            <<<'EOT'
{
    "title": "Test Workshop",
	"workshop_date": "2019-09-26"
}
EOT
        );

        static::assertResponseStatusCodeSame(201);
        static::assertResponseHasHeader('Location');

        $workshops = static::$container->get(WorkshopRepository::class)->findAll();
        static:: assertCount(1, $workshops);

        /** @var Workshop $expectedWorkshop */
        $expectedWorkshop = $workshops[0];
        static::assertSame('Test Workshop', $expectedWorkshop->getTitle());
        static::assertSame('2019-09-26', $expectedWorkshop->getWorkshopDate()->format('Y-m-d'));
    }
}
