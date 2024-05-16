<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Collections\ImportedFilesCollection;
use App\Domain\Entities\ImportedFileEntity;
use App\Domain\Repositories\ImportedFilesRepositoryInterface;
use App\Infrastructure\Models\ImportedFiles;

class EloquentImportedFilesRepository implements ImportedFilesRepositoryInterface
{
    public function __construct(
        private ImportedFiles $model
    ) {
    }

    public function store(ImportedFileEntity $entity): void
    {
        $this->model
            ->create(
                $entity->toArray()
            );
    }

    public function getAll(): ImportedFilesCollection
    {
        $files = $this->model
            ->get()
            ->toArray();

        return new ImportedFilesCollection(
            array_map(
                fn ($file) => ImportedFileEntity::fromArray($file),
                $files
            )
        );
    }
}
