<?php

declare(strict_types=1);

namespace Infrastructure\Repositories;

use App\Domain\Entities\PaymentEntity;
use App\Domain\ValueObjects\UUID;
use App\Infrastructure\Models\FailedPayment;
use App\Infrastructure\Repositories\EloquentFailedPaymentRepository;
use DateTimeImmutable;
use Tests\TestCase;

class EloquentFailedPaymentRepositoryTest extends TestCase
{
    private FailedPayment $model;
    private EloquentFailedPaymentRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->model = $this->mock(FailedPayment::class);

        $this->repository = app(EloquentFailedPaymentRepository::class);
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
