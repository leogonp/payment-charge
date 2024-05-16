<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Services\ListImportedFilesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ListImportedFilesController extends Controller
{
    public function __construct(
        private readonly ListImportedFilesService $service
    ) {
    }

    public function __invoke(): JsonResponse
    {
        try {
            $files = ($this->service)();

            return response()->json(
                $files->toArray(),
                Response::HTTP_OK,
            );
        } catch (Throwable $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }
}
