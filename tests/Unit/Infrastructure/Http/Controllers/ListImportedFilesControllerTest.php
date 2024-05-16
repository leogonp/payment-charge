<?php

declare(strict_types=1);

namespace Infrastructure\Http\Controllers;

use App\Application\Services\ListImportedFilesService;
use App\Domain\Collections\ImportedFilesCollection;
use App\Domain\Entities\ImportedFileEntity;
use App\Infrastructure\Http\Controllers\ListImportedFilesController;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ListImportedFilesControllerTest extends TestCase
{
    private ListImportedFilesService $service;
    private ListImportedFilesController $controller;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = $this->mock(ListImportedFilesService::class);

        $this->controller = app(ListImportedFilesController::class);

    }

    public function testSuccessfulImport(): void
    {
        $collection = new ImportedFilesCollection(
            [
                new ImportedFileEntity(
                    name: 'dsadsadsa',
                    size: 1234567,
                ),
                new ImportedFileEntity(
                    name: '3232',
                    size: 33333,
                ),
            ]
        );

        $this->service
            ->shouldReceive('__invoke')
            ->once()
            ->andReturn($collection);


        $response = ($this->controller)();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertCount(2, json_decode($response->getContent(), true));
    }

    public function testWillThrownExceptionResponseOnFailure()
    {
        $this->service
            ->shouldReceive('__invoke')
            ->once()
            ->andThrow(new Exception('test'));

        $response = ($this->controller)();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertArrayHasKey('message', json_decode($response->getContent(), true));
        $this->assertEquals('test', json_decode($response->getContent(), true)['message']);
    }
}
