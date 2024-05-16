<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Infrastructure\Models\ImportedFiles;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImportedFilesFactory extends Factory
{
    protected $model = ImportedFiles::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'size' => fake()->numberBetween(),

        ];
    }
}
