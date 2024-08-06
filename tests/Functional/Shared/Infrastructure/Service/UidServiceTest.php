<?php

declare(strict_types=1);

namespace Tests\Functional\Shared\Infrastructure\Service;

use App\Shared\Infrastructure\Service\UidService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UidServiceTest extends WebTestCase
{
    public function testCreateSuccess()
    {
        $ulid = UidService::generateUlid();
        $this->assertIsString($ulid);
        $this->assertEquals(strlen($ulid), 26);
    }
}
