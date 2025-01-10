<?php

namespace App\Services\Transaction\Models\Enums;

enum TransactionStatus: string
{
    case CONFIRMED = 'confirmed';
    case PENDING = 'pending';
    case CANCELED = 'canceled';
}
