<?php

use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

function waitOnRace(string $key, int $ttlInSeconds, Closure $callback)
{
    $lock = Cache::lock($key);

    try {
        return $lock->block($ttlInSeconds, $callback);
    } catch (LockTimeoutException $e) {
        optional($lock)->forceRelease();
    }
}

function dbTrx(Closure $callback, $attempts = 1)
{
    return DB::transaction($callback, $attempts);
}

function validateIban(string $iban): true
{
    return Str::startsWith($iban, 'IR')
        && (strlen($iban) === 26)
        // @todo && checksum validation
        ;
}
