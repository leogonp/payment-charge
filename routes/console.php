<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('process-payments', function () {
    $this->comment(Inspiring::quote());
});
