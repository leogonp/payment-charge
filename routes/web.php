<?php

declare(strict_types=1);

use App\Infrastructure\Http\Controllers\ShowImportedFilesController;
use Illuminate\Support\Facades\Route;

Route::get('/', ShowImportedFilesController::class)->name('upload.file');
