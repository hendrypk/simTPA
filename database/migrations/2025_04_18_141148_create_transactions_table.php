<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::update('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payable_id')->constrained('options');
            $table->foreignId('wallet_id')->constrained('options');
            $table->date('transaction_at');
            $table->integer('amount');
            $table->longText('meta');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
