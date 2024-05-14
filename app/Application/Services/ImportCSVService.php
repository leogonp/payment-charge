<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Builder\PaymentArrayBuilder;
use App\Domain\Entities\ImportedFileEntity;
use App\Domain\Producer\Producer;
use App\Domain\Repositories\ImportedFilesRepositoryInterface;
use Illuminate\Http\UploadedFile;

class ImportCSVService
{
    public function __construct(
        private ImportedFilesRepositoryInterface $repository,
        private PaymentArrayBuilder $paymentArrayBuilder,
        private Producer $producer,
    )
    {
    }

    public function __invoke(UploadedFile $file): void
    {
        $this->repository->store(
            ImportedFileEntity::fromArray([
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
            ])
        );

        $paymentCollection = $this->paymentArrayBuilder->makeToBulk($file);

        $batchSize = 1000;
        $batches = $paymentCollection->chunk($batchSize);

        foreach ($batches as $batch) {
            $batchJsonData = $batch->map(fn ($payment) => $payment->toArray())->toJson();

            $this->producer->produce($batchJsonData);
        }
    }
}
