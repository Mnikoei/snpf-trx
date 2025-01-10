<?php

namespace App\Services\Transaction\Http\Controllers\Actions\Transfer;

use App\Services\Transaction\DTOs\TransferTrxDto;
use App\Services\Transaction\Http\Requests\TransferRequest;
use App\Services\Transaction\Models\Enums\TransactionType;
use App\Services\Transaction\Models\Enums\TransferType;
use App\Services\Transaction\Models\Transaction;

class TransferAction
{
    public function __construct(private TransferRequest $request)
    {
    }

    public function transfer(): TransferTrxDto
    {
        $this->validateBalance();

        return $this->initiateTrx();
    }

    private function validateBalance(): void
    {
        abort_if(
            boolean: $this->request
                ->user()
                ->hasEnoughBalanceFor($this->request->price),

            code: 403,
            message: 'Balance is not enough!'
        );
    }

    private function initiateTrx(): TransferTrxDto
    {
        // handle db trx
        return dbTrx(function () {

            $price = $this->request->price;

            $debitTrx = Transaction::createBy(
                userId: $this->request->user()->id,
                srcIban: $this->request->fromShebaNumber,
                toIban: $this->request->toShebaNumber,
                amount: $price,
                requestId: $this->request->get('request_id'),
                type: TransferType::DEBIT,
                trxType: TransactionType::PAYA
            );

            $this->reserveBalance($price);

            return $debitTrx;
        });
    }

    public function reserveBalance(int $amount): void
    {
        $this->request->user()->reserveBalance($amount);
    }
}
