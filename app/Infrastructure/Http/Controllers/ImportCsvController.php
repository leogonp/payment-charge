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
            ($this->service)($request->toDTO());

            return response()->json(
                ['message' => 'Transaction was successfully made.'],
                Response::HTTP_CREATED,
            );
        } catch (Throwable) {
            return response()->json(
                ['message' => 'Something went wrong.'],
                Response::HTTP_INTERNAL_SERVER_ERROR,
            );
        }
    }

}
