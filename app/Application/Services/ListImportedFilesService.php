<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Builder\PaymentArrayBuilder;
use App\Application\Exceptions\InvalidCsvException;
use App\Domain\Collections\ImportedFilesCollection;
use App\Domain\Entities\ImportedFileEntity;
use App\Domain\Producer\Producer;
use App\Domain\Repositories\ImportedFilesRepositoryInterface;
use Illuminate\Http\UploadedFile;

class ListImportedFilesCSVService
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
