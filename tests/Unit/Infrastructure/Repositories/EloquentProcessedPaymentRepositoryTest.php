<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Repositories;

use App\Domain\Entities\PaymentEntity;
use App\Domain\ValueObjects\UUID;
use App\Infrastructure\Models\ProcessedPayment;
use App\Infrastructure\Repositories\EloquentProcessedPaymentRepository;
use DateTimeImmutable;
use Tests\TestCase;

class EloquentProcessedPaymentRepositoryTest extends TestCase
{
    private ProcessedPayment $model;
    private EloquentProcessedPaymentRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->model = $this->mock(ProcessedPayment::class);

        $this->repository = app(EloquentProcessedPaymentRepository::class);
    }

    public function testShouldStoreCorrectly(): void
    {
        $entity = new PaymentEntity(
            name: 'dsadsadsa',
            governmentId: '1234567',
            email: 'dsadsadsa@gmail.com',
            debtAmount: 233,
            debtDueDate: new DateTimeImmutable('2024-05-14'),
            debtId: new UUID('6286601a-3412-4cc2-be93-fd1f093740c6'),
        );

        $this->model
            ->shouldReceive('create')
            ->once()
            ->with($entity->toArray());

        $this->assertNull($this->repository->store($entity));
    }
}
