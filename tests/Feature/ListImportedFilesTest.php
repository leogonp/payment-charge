<?php

declare(strict_types=1);


use App\Infrastructure\Models\ImportedFiles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListImportedFilesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        ImportedFiles::factory()->count(10)->create();
    }

    public function testWillListAllFilesSuccessfully(): void
    {

        $response = $this->getJson(route('files.list'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['name', 'size'],
            ]);

        $this->assertDatabaseCount(ImportedFiles::class, 10);
        $response->assertJsonCount(10);
    }
}
