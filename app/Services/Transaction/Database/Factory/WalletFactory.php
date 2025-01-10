<?php

namespace App\Services\Transaction\Database\Factory;

use App\Services\Transaction\Models\Enums\WalletType;
use App\Services\Transaction\Models\Wallet;
use App\Services\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    protected $model = Wallet::class;

    public function definition(): array
    {
        return [
            'balance' => random_int(1, 10000),
            'type' => WalletType::TOTAL,
            'user_id' => User::factory()->create()->id
        ];
    }
}
