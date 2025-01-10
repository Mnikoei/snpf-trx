<?php

namespace App\Services\Transaction;

use App\Services\Utils\Transformers\Str\ToEnglishNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class TransactionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerRoutes();
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }

    public function boot()
    {
        $this->registerCardValidator();
    }

    public function registerRoutes()
    {
        Route::middleware(['web'])
            ->prefix('api/v1')
            ->group(base_path('app/Services/Transaction/Routes/routes.php'));
    }

    public function registerCardValidator(): void
    {
        Validator::extend('iban', function ($attribute, string $value) {
            return validateIban($value);
        });
    }
}
