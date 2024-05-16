<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Domain\Producer\Producer;
use App\Infrastructure\Models\ImportedFiles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImportCSVTest extends TestCase
{
    use RefreshDatabase;

    private Producer $kafkaProducer;

    public function setUp(): void
    {
        parent::setUp();

        $this->kafkaProducer = $this->mock(Producer::class);
    }

    public function testWillImportRegistersSuccessfully(): void
    {
        $fileContent = "name,governmentId,email,debtAmount,debtDue_date,debtId\nJohn Doe,123456789,johndoe@example.com,100.50,2024-06-01,6286601a-3412-4cc2-be93-fd1f093740c6\nJane Smith,987654321,janesmith@example.com,75.20,2024-05-20,e72dde81-3185-469f-b812-c5fafe8acd6d";
        Storage::put('csv/test.csv', $fileContent);

        $this->kafkaProducer
            ->shouldReceive('produce')
            ->once();

        $response = $this->postJson(route('payment.import'), [
            'file' => new UploadedFile(storage_path('app/csv/test.csv'), 'test.csv', 'text/csv', null, true),
        ]);

        $response->assertStatus(201);

        $response->assertJson([
            'message' => 'Import was successfully made.',
        ]);

        $this->assertDatabaseCount(ImportedFiles::class, 1);
        $this->assertDatabaseHas(ImportedFiles::class, [
            'name' => 'test.csv',
        ]);

        Storage::delete('csv/test.csv');
    }

    public function testFailToImportRegistersWithInvalidCSV(): void
    {
        $fileContent = "name,governmentId,email,debtAmount,debtDue_date\nJohn Doe,123456789,johndoe@example.com,100.50,2024-06-01\nJane Smith,987654321,janesmith@example.com,75.20,2024-05-20";
        Storage::put('csv/test.csv', $fileContent);

        $response = $this->postJson(route('payment.import'), [
            'file' => new UploadedFile(storage_path('app/csv/test.csv'), 'test.csv', 'text/csv', null, true),
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'message' => 'Invalid CSV format',
        ]);

        $this->assertDatabaseCount(ImportedFiles::class, 0);
        $this->assertDatabaseMissing(ImportedFiles::class, [
            'name' => 'test.csv',
        ]);

        Storage::delete('csv/test.csv');
    }

    public function testFailToImportRegistersWithInvalidUuid(): void
    {
        $fileContent = "name,governmentId,email,debtAmount,debtDue_date,debtId\nJohn Doe,123456789,johndoe@example.com,100.50,2024-06-01,6286601a-3412-4cc2-be93-\nJane Smith,987654321,janesmith@example.com,75.20,2024-05-20,e72dde81-3185-469f-b812";
        Storage::put('csv/test.csv', $fileContent);

        $response = $this->postJson(route('payment.import'), [
            'file' => new UploadedFile(storage_path('app/csv/test.csv'), 'test.csv', 'text/csv', null, true),
        ]);

        $response->assertStatus(500);

        $response->assertJson([
            'message' => 'Uuid 6286601a-3412-4cc2-be93- is not valid',
        ]);

        $this->assertDatabaseCount(ImportedFiles::class, 0);
        $this->assertDatabaseMissing(ImportedFiles::class, [
            'name' => 'test.csv',
        ]);

        Storage::delete('csv/test.csv');
    }
}
