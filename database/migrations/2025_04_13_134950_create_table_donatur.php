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
        Schema::create('donors', function (Blueprint $table) {
            $table->string('name');
            $table->integer('whatsapp');
            $table->string('address');
            $table->date('register_date');
            $table->foreignId('package_id')->constrained('options');
            $table->foreignId('status_id')->constrained('options');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donors', function (Blueprint $table) {
            $table->dropIfExists('donors');
        });
    }
};
