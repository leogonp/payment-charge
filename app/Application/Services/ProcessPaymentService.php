<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Domain\Collections\PaymentCollection;
use App\Domain\Entities\PaymentEntity;
use App\Domain\Repositories\FailedPaymentRepositoryInterface;
use App\Domain\Repositories\ProcessedPaymentRepositoryInterface;
use Throwable;

class ProcessPaymentService
{
    public function __construct(
        private EmailService $emailService,
        private ProcessedPaymentRepositoryInterface $processedPaymentRepository,
        private FailedPaymentRepositoryInterface $failedPaymentRepository,
    ) {
    }

    public function __invoke(array $paymentArray): void
    {
        $paymentCollection = new PaymentCollection(
            array_map(
                fn (array $payment) => PaymentEntity::fromArray($payment),
                $paymentArray
            )
        );

        $paymentCollection->each(
            function (PaymentEntity $payment) {
                $invoice = $this->generateInvoice($payment);

                try {
                    $this->emailService->send($invoice, $payment);
                    $this->processedPaymentRepository->store($payment);
                } catch (Throwable) {
                    $this->failedPaymentRepository->store($payment);
                }
            }
        );
    }

    private function generateInvoice(PaymentEntity $payment): string
    {
        // TODO implement method
        return 'LINK-TO-PDF-GENERATED';
    }
}
