<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Domain\Collections\PaymentCollection;
use App\Domain\Entities\PaymentEntity;

class EmailService
{
    public function __construct()
    {
    }

    public function send(string $invoice, PaymentEntity $payment): void
    {
        // TODO implement method
    }
}
