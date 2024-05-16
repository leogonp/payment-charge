<?php

declare(strict_types=1);

namespace App\Application\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidCsvException extends Exception
{
    protected $message = 'Invalid CSV format';
    protected $code = Response::HTTP_UNPROCESSABLE_ENTITY;
}
