<?php

namespace App\Services\Transaction\Database\Factory;

use App\Services\Transaction\Models\Enums\TransactionType;
use App\Services\Transaction\Models\Enums\TransferType;
use App\Services\Transaction\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'transfer_type' => TransferType::DEBIT,
            'transaction_type' => TransactionType::PAYA,
            'amount' => mt_rand(),
        ];
    }
}
