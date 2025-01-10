<?php

namespace App\Services\Transaction\Http\Requests;

use App\Services\Transaction\Models\Enums\TransactionStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DecideStatusRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status' => ['required', Rule::in(TransactionStatus::cases())],
            'note' => 'sometimes|string|max:500',
        ];
    }
}
