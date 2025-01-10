<?php

namespace App\Services\Transaction\Models;

use App\Services\Transaction\Database\Factory\TransactionFactory;
use App\Services\Transaction\Models\Enums\TransactionType;
use App\Services\Transaction\Models\Enums\TransferType;
use App\Services\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'src_iban',
        'dest_iban',
        'amount',
        'transaction_type',
        'transfer_type',
        'request_id',
        'note'
    ];
    protected $casts = [
        'transaction_type' => TransactionType::class,
        'transfer_type' => TransferType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function createBy(
        int             $userId,
        string          $srcIban,
        string          $toIban,
        int             $amount,
        string          $requestId,
        TransferType    $type,
        TransactionType $trxType,
        string          $note = ''
    ): static {

        return static::create([
            'user_id' => $userId,
            'transaction_type' => $trxType,
            'transfer_type' => $type,
            'amount' => $amount,
            'request_id' => $requestId,
            'src_iban' => $srcIban,
            'dest_iban' => $toIban,
            'note' => $note
        ]);
    }

    public function getRouteKeyName(): string
    {
        return 'request_id';
    }

    protected static function newFactory()
    {
        return TransactionFactory::new();
    }
}
