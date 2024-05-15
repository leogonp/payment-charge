<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

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
}
