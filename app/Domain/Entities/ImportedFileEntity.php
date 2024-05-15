<?php

declare(strict_types=1);

namespace App\Domain\Entities;

readonly class ImportedFileEntity
{
    public function __construct(
        public string $name,
        public int $size,
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new static(
            name: $data['name'],
            size: $data['size'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'size' => $this->size,
        ];
    }
}
