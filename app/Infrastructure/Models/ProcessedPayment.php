<?php

declare(strict_types=1);

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessedPayment extends Model
{
    protected $table = 'processed_payments';
    protected $guarded = [];
}
