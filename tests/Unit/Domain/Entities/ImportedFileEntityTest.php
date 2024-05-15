<?php

declare(strict_types=1);

namespace Domain\Entities;

use App\Domain\Entities\ImportedFileEntity;
use Tests\TestCase;

class ImportedFileEntityTest extends TestCase
{
    public function testWillBuildFromArray(): void
    {
        $data = [
            'name' => 'dsadsadsa',
            'size' => 1234567,
        ];

        $entity = ImportedFileEntity::fromArray($data);

        $this->assertEquals($data['name'], $entity->name);
        $this->assertEquals($data['size'], $entity->size);
    }

    public function testWillConvertToArray(): void
    {
        $entity = new ImportedFileEntity(
            name: 'dsadsadsa',
            size: 1234567,
        );

        $dataArray = $entity->toArray();

        $this->assertEquals($entity->name, $dataArray['name']);
        $this->assertEquals($entity->size, $dataArray['size']);
    }
}
