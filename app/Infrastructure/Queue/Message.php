<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue;

use Illuminate\Support\Arr;

readonly class Message
{
    public function __construct(
        private array $payload,
        private mixed $original
    ) {
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->payload, $key, $default);
    }

    public function getOriginalMessage(): mixed
    {
        return $this->original;
    }
}
