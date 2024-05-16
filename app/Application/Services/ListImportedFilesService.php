<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Domain\Collections\ImportedFilesCollection;
use App\Domain\Repositories\ImportedFilesRepositoryInterface;

class ListImportedFilesService
{
    public function __construct(
        private ImportedFilesRepositoryInterface $repository,
    ) {
    }

    public function __invoke(): ImportedFilesCollection
    {
        return $this->repository->getAll();
    }
}
