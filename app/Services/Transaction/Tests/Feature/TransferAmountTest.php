<?php

namespace App\Services\Transaction\Tests\Feature;

use App\Services\Transaction\Models\Enums\WalletType;
use App\Services\Transaction\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class TransferAmountTest extends TestCase
{
    use RefreshDatabase;

    public function testCanTransferMoney()
    {
        $user = $this->authenticatedUser();

        Wallet::factory()->for($user)->create(['type' => WalletType::TOTAL, 'balance' => 10000]);
        Wallet::factory()->for($user)->create(['type' => WalletType::RESERVE, 'balance' => 0]);

        $response = $this->postJson('api/v1/transaction/transfer', [
            'price' => $amount = 50000,
            'fromShebaNumber' => $this->generateValidFakeIBAN(),
            'toShebaNumber' => $this->generateValidFakeIBAN(),
            'note' => fake()->paragraph,
            'request_id' => Str::uuid()
        ]);

        $this->assertDatabaseCount('transactions', 2);

        $this->assertDatabaseHas('transactions', [


        ]);

        $response->assertOk();
    }

    public function testIdempotency(){}

    public function testRaceCondition(){}

    public function assertStoresTrxCorrectly(){}
}
