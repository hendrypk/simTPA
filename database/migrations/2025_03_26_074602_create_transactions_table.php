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
        // Schema::create('transactions', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('transaction_id');
        //     $table->unsignedBigInteger('contact_id');
        //     $table->unsignedBigInteger('wallet_id');
        //     $table->date('date');
        //     $table->unsignedBigInteger('category_id');
        //     $table->integer('amount');
        //     $table->string('description');
        //     $table->string('attachment');
        //     $table->boolean('hide_contact')->nullable();
        //     $table->softDeletes();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('transactions');
    }
};
