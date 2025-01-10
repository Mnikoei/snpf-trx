<?php

use App\Services\User\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('request_id')->index();
            $table->foreignIdFor(User::class);

            $table->string('transfer_type');
            $table->string('transaction_type');
            $table->string('src_iban', 26);
            $table->string('dest_iban', 26);
            $table->decimal('amount', 12, 2);
            $table->string('note', 500);

            $table->timestamps();

            // To make sure if bypassed idempotency
            // it won't save same uuid
            $table->unique('request_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
