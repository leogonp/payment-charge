<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\Services\ImportCSVService;
use App\Infrastructure\Http\Controllers\Request\ImportCSVRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ImportCsvController extends Controller
{

    public function __construct(
        private readonly ImportCSVService $service
    ) {
    }

    public function __invoke(ImportCSVRequest $request): JsonResponse
    {
        try {
            ($this->service)($request->toFile());

            return response()->json(
                ['message' => 'Import was successfully made.'],
                Response::HTTP_CREATED,
            );
        } catch (Throwable $e) {
            return response()->json(
                ['message' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }

}
