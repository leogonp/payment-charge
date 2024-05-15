<?php

declare(strict_types=1);

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class ImportedFiles extends Model
{
    protected $table = 'imported_files';
    protected $guarded = [];
}
