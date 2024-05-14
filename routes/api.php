<?php

declare(strict_types=1);

use App\Infrastructure\Http\Controllers\ImportCsvController;
use Illuminate\Support\Facades\Route;

Route::prefix('import')->group(function () {
    Route::post('/', ImportCsvController::class)
        ->name('payment.import');
});
