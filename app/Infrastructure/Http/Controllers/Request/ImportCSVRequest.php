<?php

declare (strict_types=1);

namespace App\Infrastructure\Http\Controllers\Request;

use App\Application\DTO\MakeTransactionInputDTO;
use Illuminate\Foundation\Http\FormRequest;

class ImportCSVRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payer' => ['required', 'int'],
            'payee' => ['required', 'int'],
            'value' => ['required', 'numeric', 'gt:0'],
        ];
    }

    public function toDTO(): MakeTransactionInputDTO
    {
        $data = $this->validated();

        return MakeTransactionInputDTO::fromArray([
            'payer_user_id' => $data['payer'],
            'payee_user_id' => $data['payee'],
            'value' => $data['value'],
        ]);
    }
}
