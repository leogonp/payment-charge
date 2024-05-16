<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Http\Controllers;

use App\Application\Services\ImportCSVService;
use App\Infrastructure\Http\Controllers\ImportCsvController;
use App\Infrastructure\Http\Controllers\Request\ImportCSVRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ImportCsvControllerTest extends TestCase
{
    private ImportCSVService $service;
    private ImportCsvController $controller;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = $this->mock(ImportCSVService::class);

        $this->controller = app(ImportCsvController::class);

    }

    public function testSuccessfulImport()
    {
        $this->service
            ->shouldReceive('__invoke')
            ->once()
            ->with($this->isInstanceOf(UploadedFile::class));

        $uploadedFile = UploadedFile::fake()->create('data.csv');

        $request = $this->mock(ImportCSVRequest::class);

        $request->shouldReceive('toFile')
            ->once()
            ->andReturn($uploadedFile);

        $response = ($this->controller)($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertArrayHasKey('message', json_decode($response->getContent(), true));
        $this->assertEquals('Import was successfully made.', json_decode($response->getContent(), true)['message']);
    }

    public function testWillThrownExceptionResponseOnFailure(): void
    {
        $this->service
            ->shouldReceive('__invoke')
            ->once()
            ->with($this->isInstanceOf(UploadedFile::class))
            ->andThrow(new Exception('Failed to import CSV'));

        $uploadedFile = UploadedFile::fake()->create('data.csv');

        $request = $this->mock(ImportCSVRequest::class);

        $request->shouldReceive('toFile')
            ->once()
            ->andReturn($uploadedFile);

        $response = ($this->controller)($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertArrayHasKey('message', json_decode($response->getContent(), true));
        $this->assertEquals('Failed to import CSV', json_decode($response->getContent(), true)['message']);
    }
}
