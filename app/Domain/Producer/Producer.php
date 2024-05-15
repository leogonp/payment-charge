<?php

declare(strict_types=1);

namespace App\Domain\Producer;

interface Producer
{
    public function produce(string $message): void;
}
