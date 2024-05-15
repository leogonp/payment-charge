<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

use App\Domain\Queue\QueueInterface;

class ProcessPaymentsCommand
{
    public function handle(): void
    {
        $worker = app(QueueInterface::class);

        $worker->run();
    }
}
