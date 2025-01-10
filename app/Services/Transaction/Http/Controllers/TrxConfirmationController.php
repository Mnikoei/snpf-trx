<?php

namespace App\Services\Transaction\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Transaction\Http\Controllers\Actions\Confirmation\TrxCancelAction;
use App\Services\Transaction\Http\Controllers\Actions\Confirmation\TrxConfirmAction;
use App\Services\Transaction\Http\Requests\DecideStatusRequest;
use App\Services\Transaction\Models\Enums\TransactionStatus;
use App\Services\Transaction\Models\Transaction;

class TrxConfirmationController extends Controller
{
    public function changeStatus(DecideStatusRequest $request, Transaction $trx)
    {
        $trx = waitOnRace(
            key: "trx-id:{$trx->request_id}:race-key",
            ttlInSeconds: 60,
            callback: fn() => $this->handleStatusChange($request, $trx)
        );

        return response()->json();
    }

    private function handleStatusChange(
        DecideStatusRequest $request,
        Transaction $trx

    ): Transaction{

        return match ($request->get('status')) {
            TransactionStatus::CONFIRMED => (new TrxConfirmAction($trx))->handle(),
            TransactionStatus::CANCELED => (new TrxCancelAction($trx))->handle(),
        };
    }
}
