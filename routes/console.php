<?php

declare(strict_types=1);

use App\Infrastructure\Command\ProcessPaymentsCommand;
use Illuminate\Support\Facades\Artisan;

Artisan::command('process-payments', function () {
    app(ProcessPaymentsCommand::class)->handle();
});
