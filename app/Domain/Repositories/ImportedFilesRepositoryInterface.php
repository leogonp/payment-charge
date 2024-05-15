<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\ImportedFileEntity;

interface ImportedFilesRepositoryInterface
{
    public function store(ImportedFileEntity $entity): void;
}
