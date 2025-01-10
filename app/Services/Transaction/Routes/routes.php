<?php

use App\Services\Transaction\Http\Controllers\TrxConfirmationController;
use App\Services\Transaction\Http\Controllers\TransferController;

Route::prefix('transaction')->middleware('throttle:10,1')->group(function () {

    Route::post('/transfer', [TransferController::class, 'transfer']);
    Route::post('/iban/{request_id}', [TrxConfirmationController::class, 'changeStatus']);
});
