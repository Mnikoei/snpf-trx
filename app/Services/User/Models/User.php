<?php

namespace App\Services\User\Models;

use App\Services\Transaction\Models\Enums\WalletType;
use App\Services\Transaction\Models\Wallet;
use App\Services\User\Database\Factory\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'password',
    ];

    protected $hidden = [
        'password'
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    public function reserveBalance(int $amount): void
    {
        Wallet::for(userId: $this->id, type: WalletType::RESERVE)->increase($amount);
    }

    public function releaseBalance(int $amount): void
    {
        Wallet::for(userId: $this->id, type: WalletType::RESERVE)->decrease($amount);
    }

    public function decreaseBalance(int $amount): void
    {
        Wallet::for(userId: $this->id, type: WalletType::RESERVE)->decrease($amount);
        Wallet::for(userId: $this->id, type: WalletType::TOTAL)->decrease($amount);
    }

    public function hasEnoughBalanceFor(int $amount): bool
    {
        $total = Wallet::for(userId: $this->id, type: WalletType::TOTAL);
        $reserved = Wallet::for(userId: $this->id, type: WalletType::RESERVE);

        return ($total->balance - $reserved->balance) >= $amount;
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
