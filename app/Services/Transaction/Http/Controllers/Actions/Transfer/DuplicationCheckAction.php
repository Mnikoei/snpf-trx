<?php

namespace App\Services\Transaction\Http\Controllers\Actions\Transfer;

use App\Services\Transaction\Http\Requests\TransferRequest;
use Illuminate\Support\Facades\Cache;

readonly class DuplicationCheckAction
{
    public function __construct(private TransferRequest $request)
    {
    }

    public function check(): void
    {
        abort_if(
            $this->keyExists(),
            403,
            'Duplicate Trx, try ' . static::getIdempotencyExpInSeconds() . ' seconds later!'
        );

        $this->setKeyInCache();
    }

    private function keyExists(): bool
    {
        return Cache::tags('transfer')->has($this->getCacheKey());
    }

    public function setKeyInCache(): void
    {
        Cache::tags('transfer')->put(
            key: $this->getCacheKey(),
            value: true,
            ttl: static::getIdempotencyExpInSeconds()
        );
    }

    public function getCacheKey(): string
    {
        return 'trx-idempotency:'
            . $this->request->user()->id
            . '_'
            . $this->request->unique_key;
    }

    public static function getIdempotencyExpInSeconds(): int
    {
        return 20; // configurable in production
    }
}
