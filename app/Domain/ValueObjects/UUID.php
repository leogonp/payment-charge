<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

readonly class UUID
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $value
    ) {
        $this->validate();
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validate(): void
    {
        if (! $this->isValid()) {
            throw new InvalidArgumentException(
                sprintf(
                    'Uuid %s is not valid',
                    $this->value
                )
            );
        }
    }

    private function isValid(): bool
    {
        return (bool) preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $this->value);
    }
}
