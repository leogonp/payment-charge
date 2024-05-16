<?php

declare(strict_types=1);

namespace Application\Service;

use App\Application\Services\ListImportedFilesService;
use App\Domain\Collections\ImportedFilesCollection;
use App\Domain\Entities\ImportedFileEntity;
use App\Domain\Repositories\ImportedFilesRepositoryInterface;
use Tests\TestCase;

class ListImportedFilesServiceTest extends TestCase
{
    private ListImportedFilesService $service;
    private ImportedFilesRepositoryInterface $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->mock(ImportedFilesRepositoryInterface::class);

        $this->service = app(ListImportedFilesService::class);
    }

    public function testSuccessfulImport(): void
    {
        $collection = new ImportedFilesCollection(
            [
                new ImportedFileEntity(
                    name: 'dsadsadsa',
                    size: 1234567,
                ),
                new ImportedFileEntity(
                    name: '3232',
                    size: 33333,
                ),
            ]
        );

        $this->repository
            ->shouldReceive('getAll')
            ->once()
            ->andReturn($collection);

        $this->assertEquals($collection, ($this->service)());
    }
}
