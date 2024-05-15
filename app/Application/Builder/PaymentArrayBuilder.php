<?php

declare(strict_types=1);

namespace App\Application\Builder;

use App\Domain\Collections\PaymentCollection;
use App\Domain\Entities\PaymentEntity;
use Illuminate\Http\UploadedFile;

class PaymentArrayBuilder
{
    public function __construct(
        private FileReader $fileReader,
    ) {
    }

    public function makeToBulk(UploadedFile $file): PaymentCollection
    {
        $csvData = $this->fileReader->readCsvFile($file->getRealPath());

        $paymentCollection = new PaymentCollection();

        $csvData->skip(1)->each(function ($data) use (&$paymentCollection) {
            $content = [
                'name' => $data[0],
                'government_id' => $data[1],
                'email' => $data[2],
                'debt_amount' => $data[3],
                'debt_due_date' => $data[4],
                'debt_id' => $data[5],
            ];

            $payment = PaymentEntity::fromArray($content);

            $paymentCollection->add($payment);
        });

        return $paymentCollection;
    }
}
