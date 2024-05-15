<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Repositories;

use App\Domain\Entities\ImportedFileEntity;
use App\Infrastructure\Models\ImportedFiles;
use App\Infrastructure\Repositories\EloquentImportedFilesRepository;
use Tests\TestCase;

class EloquentImportedFilesRepositoryTest extends TestCase
{
    private ImportedFiles $model;
    private EloquentImportedFilesRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->model = $this->mock(ImportedFiles::class);

        $this->repository = app(EloquentImportedFilesRepository::class);
    }

    public function testShouldStoreCorrectly(): void
    {
        $entity = new ImportedFileEntity(
            name: 'dsadsadsa',
            size: 1234567,
        );

        $this->model
            ->shouldReceive('create')
            ->once()
            ->with($entity->toArray());

        $this->assertNull($this->repository->store($entity));
    }
}
