<?php

declare(strict_types=1);

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class FailedPayment extends Model
{
    protected $table = 'failed_payments';
    protected $guarded = [];
}
