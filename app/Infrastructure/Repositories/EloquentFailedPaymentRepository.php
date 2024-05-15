<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\PaymentEntity;
use App\Domain\Repositories\FailedPaymentRepositoryInterface;
use App\Infrastructure\Models\FailedPayment;

class EloquentFailedPaymentRepository implements FailedPaymentRepositoryInterface
{
    public function __construct(
        private FailedPayment $model
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
