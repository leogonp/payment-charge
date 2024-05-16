<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Services\ListImportedFilesService;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class ShowImportedFilesController extends Controller
{
    public function __construct(
        private readonly ListImportedFilesService $service
    ) {
    }

    public function __invoke(): View
    {
        $files = ($this->service)();

        return view('upload-file', compact('files'));
    }
}
