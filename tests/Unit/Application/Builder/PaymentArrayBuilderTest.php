<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Builder;

use App\Application\Builder\FileReader;
use App\Application\Builder\PaymentArrayBuilder;
use App\Domain\Collections\PaymentCollection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\LazyCollection;
use Tests\TestCase;

class PaymentArrayBuilderTest extends TestCase
{
    public function testMakeToBulk(): void
    {
        $fileReaderMock = $this->mock(FileReader::class);

        $csvData = new LazyCollection([
            ['a', 'b', 'c', 'd', 'e', 'f'],
            ['dsadsa', '123456789', '32132d@dsadsads.com', 100.50, '2024-06-01', '6286601a-3412-4cc2-be93-fd1f093740c6'],
            ['dsadsddsa', '987654321', 'dsadsa@dsadsadsa.com', 75.20, '2024-05-20', 'e72dde81-3185-469f-b812-c5fafe8acd6d'],
        ]);

        $fileReaderMock->shouldReceive('readCsvFile')
            ->once()
            ->andReturn($csvData);

        $paymentArrayBuilder = app(PaymentArrayBuilder::class);

        $uploadedFile = UploadedFile::fake()->create('payments.csv');

        $paymentCollection = $paymentArrayBuilder->makeToBulk($uploadedFile);

        $this->assertInstanceOf(PaymentCollection::class, $paymentCollection);
        $this->assertCount(2, $paymentCollection);

        $this->assertEquals('dsadsa', $paymentCollection[0]->name);
        $this->assertEquals('123456789', $paymentCollection[0]->governmentId);
        $this->assertEquals('32132d@dsadsads.com', $paymentCollection[0]->email);
        $this->assertEquals(100.50, $paymentCollection[0]->debtAmount);
        $this->assertEquals('2024-06-01', $paymentCollection[0]->debtDueDate->format('Y-m-d'));
        $this->assertEquals('6286601a-3412-4cc2-be93-fd1f093740c6', (string) $paymentCollection[0]->debtId);

        $this->assertEquals('dsadsddsa', $paymentCollection[1]->name);
        $this->assertEquals('987654321', $paymentCollection[1]->governmentId);
        $this->assertEquals('dsadsa@dsadsadsa.com', $paymentCollection[1]->email);
        $this->assertEquals(75.20, $paymentCollection[1]->debtAmount);
        $this->assertEquals('2024-05-20', $paymentCollection[1]->debtDueDate->format('Y-m-d'));
        $this->assertEquals('e72dde81-3185-469f-b812-c5fafe8acd6d', (string) $paymentCollection[1]->debtId);
    }
}
