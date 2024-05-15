<?php

declare (strict_types=1);

namespace App\Infrastructure\Http\Controllers\Request;

use App\Application\DTO\MakeTransactionInputDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class ImportCSVRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => ['required', 'file'],
        ];
    }

    public function toFile(): UploadedFile
    {
        $data = $this->validated();

        return $data['file'];
    }
}
