<?php

namespace Tests;

use App\Services\AccessLevel\Models\Role;
use App\Services\User\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    public function authenticatedUser(array $data = []): User
    {
        $user = $this->user($data);

        $this->actingAs($user);

        return $user;
    }
    public function user(array $data = []): User
    {
        return User::factory()->create($data);
    }

    /**
     * I used AI for this
     */
    public function generateValidFakeIBAN() {
        $countryCode = 'IR';
        $checkDigits = '00';

        $accountNumber = '';
        for ($i = 0; $i < 22; $i++) {
            $accountNumber .= mt_rand(0, 9);
        }

        $ibanNumeric = str_replace(
            range('A', 'Z'),
            range(10, 35),
            $accountNumber . $countryCode . $checkDigits
        );

        $remainder = bcmod($ibanNumeric, 97);

        $validCheckDigits = str_pad(98 - $remainder, 2, '0', STR_PAD_LEFT);

        return $countryCode . $validCheckDigits . $accountNumber;
    }
}
