<?php

namespace App\Domain\Collections;

use App\Domain\Entities\PaymentEntity;
use Illuminate\Support\Collection;

class PaymentCollection extends Collection
{
    public function toArray(): array
    {
        return array_map(fn (PaymentEntity $payment) => $payment->toArray(), $this->items);
    }
}
