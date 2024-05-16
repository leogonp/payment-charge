<?php

declare(strict_types=1);

use App\Infrastructure\Http\Controllers\ImportCsvController;
use App\Infrastructure\Http\Controllers\ListImportedFilesController;
use Illuminate\Support\Facades\Route;

Route::prefix('import')->group(function () {
    Route::post('/', ImportCsvController::class)
        ->name('payment.import');

    Route::get('/', ListImportedFilesController::class)
        ->name('files.list');
});
