<?php

declare(strict_types=1);

namespace App\Infrastructure\Models;

use Database\Factories\ImportedFilesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportedFiles extends Model
{
    use HasFactory;

    protected $table = 'imported_files';
    protected $guarded = [];

    protected static function newFactory(): ImportedFilesFactory
    {
        return ImportedFilesFactory::new();
    }
}
