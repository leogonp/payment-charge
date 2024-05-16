<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Service;

use App\Application\Services\EmailService;
use App\Application\Services\ProcessPaymentService;
use App\Domain\Repositories\FailedPaymentRepositoryInterface;
use App\Domain\Repositories\ProcessedPaymentRepositoryInterface;
use Exception;
use Tests\TestCase;

class ProcessPaymentServiceTest extends TestCase
{
    private ProcessPaymentService $service;
    private EmailService $emailService;
    private ProcessedPaymentRepositoryInterface $processedPaymentRepository;
    private FailedPaymentRepositoryInterface $failedPaymentRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->emailService = $this->mock(EmailService::class);
        $this->processedPaymentRepository = $this->mock(ProcessedPaymentRepositoryInterface::class);
        $this->failedPaymentRepository = $this->mock(FailedPaymentRepositoryInterface::class);

        $this->service = app(ProcessPaymentService::class);
    }

    public function testSuccessfulProcessAllPayments(): void
    {

        $payments = [
            [
                'name' => 'dsadsadsa',
                'government_id' => '1234567',
                'email' => 'dsadsadsa@gmail.com',
                'debt_amount' => 233,
                'debt_due_date' => '2024-05-14',
                'debt_id' => '6286601a-3412-4cc2-be93-fd1f093740c6',
            ],
            [
                'name' => 'sadsadasgfdgfd',
                'government_id' => '7657657',
                'email' => 'gh@gfhgf.com',
                'debt_amount' => 2343,
                'debt_due_date' => '2024-05-11',
                'debt_id' => 'e72dde81-3185-469f-b812-c5fafe8acd6d',
            ],
        ];

        $this->emailService
            ->shouldReceive('send')
            ->twice();

        $this->processedPaymentRepository
            ->shouldReceive('store')
            ->twice();

        $this->assertNull(($this->service)($payments));
    }

    public function testWillProcessAFewPaymentsCorrectly(): void
    {

        $payments = [
            [
                'name' => 'dsadsadsa',
                'government_id' => '1234567',
                'email' => 'dsadsadsa@gmail.com',
                'debt_amount' => 233,
                'debt_due_date' => '2024-05-14',
                'debt_id' => '6286601a-3412-4cc2-be93-fd1f093740c6',
            ],
            [
                'name' => 'sadsadasgfdgfd',
                'government_id' => '7657657',
                'email' => 'gh@gfhgf.com',
                'debt_amount' => 2343,
                'debt_due_date' => '2024-05-11',
                'debt_id' => 'e72dde81-3185-469f-b812-c5fafe8acd6d',
            ],
        ];

        $this->emailService
            ->shouldReceive('send')
            ->twice()
            ->andThrow(Exception::class);

        $this->processedPaymentRepository
            ->shouldReceive('store')
            ->never();

        $this->failedPaymentRepository
            ->shouldReceive('store')
            ->twice();

        $this->assertNull(($this->service)($payments));
    }

    public function testWillFailProcessingAllPayments(): void
    {

        $payments = [
            [
                'name' => 'dsadsadsa',
                'government_id' => '1234567',
                'email' => 'dsadsadsa@gmail.com',
                'debt_amount' => 233,
                'debt_due_date' => '2024-05-14',
                'debt_id' => '6286601a-3412-4cc2-be93-fd1f093740c6',
            ],
            [
                'name' => 'sadsadasgfdgfd',
                'government_id' => '7657657',
                'email' => 'gh@gfhgf.com',
                'debt_amount' => 2343,
                'debt_due_date' => '2024-05-11',
                'debt_id' => 'e72dde81-3185-469f-b812-c5fafe8acd6d',
            ],
        ];

        $this->emailService
            ->shouldReceive('send')
            ->once();

        $this->emailService
            ->shouldReceive('send')
            ->once()
            ->andThrow(Exception::class);

        $this->processedPaymentRepository
            ->shouldReceive('store')
            ->once();

        $this->failedPaymentRepository
            ->shouldReceive('store')
            ->once();

        $this->assertNull(($this->service)($payments));
    }
}
