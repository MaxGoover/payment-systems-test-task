<?php

declare(strict_types=1);

namespace Tests\Functional\Shared\Infrastructure\Service;

use App\Shared\Infrastructure\Service\UidService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UidServiceTest extends WebTestCase
{
    public function testGenerateUuidSuccess()
    {
        $ulid = UidService::generateUuid();
        $this->assertIsString($ulid);
        $this->assertEquals(mb_strlen($ulid), 36);
    }
}
