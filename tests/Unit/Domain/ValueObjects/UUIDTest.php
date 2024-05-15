<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObjects;

use App\Domain\ValueObjects\UUID;
use InvalidArgumentException;
use Tests\TestCase;

class UUIDTest extends TestCase
{
    public function testValidUUID(): void
    {
        $uuidString = '550e8400-e29b-41d4-a716-446655440000';
        $uuid = new UUID($uuidString);

        $this->assertInstanceOf(UUID::class, $uuid);
        $this->assertEquals($uuidString, $uuid->__toString());
    }

    public function testInvalidUUID(): void
    {
        $invalidUuidString = 'invalid-uuid';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Uuid ' . $invalidUuidString . ' is not valid');

        new UUID($invalidUuidString);
    }

    public function testEmptyUUID(): void
    {
        $emptyUuidString = '';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Uuid ' . $emptyUuidString . ' is not valid');

        new UUID($emptyUuidString);
    }
}
