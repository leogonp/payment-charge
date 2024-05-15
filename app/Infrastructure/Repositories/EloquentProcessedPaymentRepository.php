<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\PaymentEntity;
use App\Domain\Repositories\ProcessedPaymentRepositoryInterface;
use App\Infrastructure\Models\ProcessedPayment;

class EloquentProcessedPaymentRepository implements ProcessedPaymentRepositoryInterface
{
    public function __construct(
        private ProcessedPayment $model
    ) {
    }

    public function store(PaymentEntity $entity): void
    {
        $this->model
            ->create(
                $entity->toArray()
            );
    }
}
