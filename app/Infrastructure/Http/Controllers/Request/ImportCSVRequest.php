<?php

declare (strict_types=1);

namespace App\Infrastructure\Http\Controllers\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class ImportCSVRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ];
    }

    public function toFile(): UploadedFile
    {
        $data = $this->validated();

        return $data['file'];
    }
}
