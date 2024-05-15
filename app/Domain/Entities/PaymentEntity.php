<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\UUID;
use DateTimeImmutable;

readonly class PaymentEntity
{
    public function __construct(
        public string $name,
        public string $governmentId,
        public string $email,
        public float $debtAmount,
        public DateTimeImmutable $debtDueDate,
        public UUID $debtId,
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            name: $data['name'],
            governmentId: $data['government_id'],
            email: $data['email'],
            debtAmount: (float) $data['debt_amount'],
            debtDueDate: new DateTimeImmutable($data['debt_due_date']),
            debtId: new UUID($data['debt_id']),
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'government_id' => $this->governmentId,
            'email' => $this->email,
            'debt_amount' => $this->debtAmount,
            'debt_due_date' => $this->debtDueDate->format('Y-m-d'),
            'debt_id' => (string) $this->debtId,
        ];
    }
}
