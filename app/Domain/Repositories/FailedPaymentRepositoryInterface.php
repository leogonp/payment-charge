<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\PaymentEntity;

interface FailedPaymentRepositoryInterface
{
    public function store(PaymentEntity $entity): void;
}
