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
        Schema::table('contacts', function (Blueprint $table) {
            $table->enum('type', ['employee', 'donor', 'student', 'vendor'])->change();
            $table->date('register_date')->nullable();
            $table->integer('cid')->nullable();
            $table->string('place_birth')->nullable();
            $table->date('date_birth')->nullable();
            $table->string('guardian_name')->nullable();
            $table->bigInteger('guardian_number')->nullable();
            $table->foreignId('school_id')->nullable()->constrained('options');
            $table->foreignId('class_id')->nullable()->constrained('options');
            $table->dropColumn('status');
            $table->foreignId('status_id')->nullable()->constrained('options');
            $table->foreignId('employee_category_id')->nullable()->constrained('options');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->enum('type', ['donor', 'teacher', 'staff', 'vendor'])->change();
            $table->integer('status');
            $table->dropColumn(['register_date', 'cid', 'place_birth', 'date_birth', 'guardian_name', 'guardian_number',
            'school_id', 'class_id', 'status_id', 'employoee_category_id']); 
        });
    }
};
