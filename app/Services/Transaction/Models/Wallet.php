<?php

namespace App\Services\Transaction\Models;

use App\Services\Transaction\Database\Factory\WalletFactory;
use App\Services\Transaction\Models\Enums\WalletType;
use App\Services\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'balance', 'type'];

    protected $casts = [
        'type' => WalletType::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function for(int $userId, WalletType $type): static
    {
        return static::query()
            ->where('user_id', $userId)
            ->where('type', $type)
            ->first();
    }

    public function increase(int $amount): void
    {
        $this->increment('balance', $amount);
    }

    public function decrease(int $amount): void
    {
        $this->decrement('balance', $amount);
    }

    protected static function newFactory()
    {
        return WalletFactory::new();
    }
}
