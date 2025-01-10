<?php

namespace App\Services\Transaction\Http\Controllers\Actions\Confirmation;

use App\Services\Transaction\Models\Enums\TransactionStatus;
use App\Services\Transaction\Models\Enums\TransactionType;
use App\Services\Transaction\Models\Enums\TransferType;
use App\Services\Transaction\Models\Transaction;

readonly class TrxConfirmAction
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
        $this->trx->update(['status' => TransactionStatus::CONFIRMED]);

        $this->trx->user()->decreaseBalance($this->trx->amount);

        // @todo $this->destinationUser->increaseBalance()

        return $this->createMateTrx();
    }

    // @todo this should be related to end user
    // but I dont have enough time :D
    public function createMateTrx(): Transaction
    {
        return tap(
            $this->trx->replicate()->fill([
                'status' => TransactionStatus::CONFIRMED,
                'transfer_type' => TransferType::CREDIT,
                'transaction_type' => TransactionType::PAYA
                // @todo dest user
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
