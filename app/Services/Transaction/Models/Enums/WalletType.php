<?php

namespace App\Services\Transaction\Models\Enums;

enum WalletType: string
{
    case TOTAL = 'total';

    case RESERVE = 'reserve';
}
