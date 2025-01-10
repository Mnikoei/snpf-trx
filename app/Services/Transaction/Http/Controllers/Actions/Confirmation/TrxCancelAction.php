<?php

namespace App\Services\Transaction\Http\Controllers\Actions\Confirmation;

use App\Services\Transaction\Models\Enums\TransactionStatus;
use App\Services\Transaction\Models\Enums\TransactionType;
use App\Services\Transaction\Models\Enums\TransferType;
use App\Services\Transaction\Models\Transaction;

readonly class TrxCancelAction
{
    public function __construct(private Transaction $trx)
    {
    }

    public function handle(): Transaction
    {
        $this->validateCurrentStatus();

        return dbTrx(fn() => $this->cancelTrx());
    }

    private function cancelTrx(): Transaction
    {
        $this->trx->update(['status' => TransactionStatus::CANCELED]);

        $this->trx->user()->releaseBalance($this->trx->amount);

        return tap(
            $this->trx->replicate()->fill([
                'status' => TransactionStatus::CONFIRMED,
                'transfer_type' => TransferType::CREDIT,
                'transaction_type' => TransactionType::PAYA_REVERSE
            ])
        )->save();
    }

    private function validateCurrentStatus(): void
    {
        abort_if(
            boolean: $this->trx->status !== TransactionStatus::PENDING,
            code: 403,
            message: 'Invalid status!'
        );
    }
}
