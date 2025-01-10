<?php

namespace App\Services\Transaction\Models\Enums;

enum TransactionType: string
{
    case PAYA = 'paya';

    case PAYA_REVERSE = 'paya_reverse';
}
