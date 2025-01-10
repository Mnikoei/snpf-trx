<?php

namespace App\Services\Transaction\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public function rules()
    {
        return [
            'price' => 'required|integer|min:100',
            'fromShebaNumber' => 'required|iban',
            'toShebaNumber' => 'required|iban',
            'note' => 'required|string|min:10',
            'request_id' => 'required|uuid'
        ];
    }
}
