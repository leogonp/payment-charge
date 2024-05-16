<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Service;

use App\Application\Builder\PaymentArrayBuilder;
use App\Application\Services\ImportCSVService;
use App\Domain\Collections\PaymentCollection;
use App\Domain\Entities\PaymentEntity;
use App\Domain\Producer\Producer;
use App\Domain\Repositories\ImportedFilesRepositoryInterface;
use App\Domain\ValueObjects\UUID;
use DateTimeImmutable;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImportCSVServiceTest extends TestCase
{
    private ImportCSVService $service;
    private ImportedFilesRepositoryInterface $repository;
    private PaymentArrayBuilder $paymentArrayBuilder;
    private Producer $kafkaProducer;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->mock(ImportedFilesRepositoryInterface::class);
        $this->paymentArrayBuilder = $this->mock(PaymentArrayBuilder::class);
        $this->kafkaProducer = $this->mock(Producer::class);

        $this->service = app(ImportCSVService::class);
    }

    public function testSuccessfulImport(): void
    {
        $uploadFile = $this->mock(UploadedFile::class);

        $collection = new PaymentCollection(
            [
                new PaymentEntity(
                    name: 'dsadsadsa',
                    governmentId: '1234567',
                    email: 'dsadsadsa@gmail.com',
                    debtAmount: 233,
                    debtDueDate: new DateTimeImmutable('2024-05-14'),
                    debtId: new UUID('6286601a-3412-4cc2-be93-fd1f093740c6'),
                ),
                new PaymentEntity(
                    name: 'dsadsadsa',
                    governmentId: 'dsadsadas',
                    email: '3654654@sda.com',
                    debtAmount: 233,
                    debtDueDate: new DateTimeImmutable('2024-05-12'),
                    debtId: new UUID('e72dde81-3185-469f-b812-c5fafe8acd6d'),
                ),
            ]
        );

        $uploadFile->shouldReceive('getClientOriginalName')
            ->once()
            ->andReturn('name');

        $uploadFile->shouldReceive('getSize')
            ->once()
            ->andReturn(123);

        $this->repository
            ->shouldReceive('store')
            ->once();

        $this->paymentArrayBuilder
            ->shouldReceive('makeToBulk')
            ->with($uploadFile)
            ->once()
            ->andReturn($collection);

        $this->kafkaProducer
            ->shouldReceive('produce')
            ->once();

        $this->assertNull(($this->service)($uploadFile));
    }
}
