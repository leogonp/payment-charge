<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Repositories;

use App\Domain\Collections\ImportedFilesCollection;
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

    public function testShouldGetAllCorrectly(): void
    {
        $data = [
            [
                'name' => 'file1',
                'size' => 123,
            ],
            [
                'name' => 'file2',
                'size' => 456,
            ],
            [
                'name' => 'file3',
                'size' => 789,
            ],
        ];


        $this->model
            ->shouldReceive('get->toArray')
            ->once()
            ->andReturn($data);

        $collection = $this->repository->getAll();

        $this->assertInstanceOf(ImportedFilesCollection::class, $collection);
        $this->assertCount(3, $collection);
    }
}
