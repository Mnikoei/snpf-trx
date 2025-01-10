<?php

namespace App\Services\Transaction\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TransferAmountInoutValidationTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('transferInputDataProvider')]
    public function testInputValidation($payload, $expectedStatus)
    {
        $this->authenticatedUser();

        $response = $this->postJson('api/v1/transaction/transfer', $payload);

        $response->assertStatus($expectedStatus);
    }

    public static function transferInputDataProvider()
    {
        return [
            // data

        ];
    }
}
