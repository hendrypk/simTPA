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
        Schema::table('options', function (Blueprint $table) {
            // Modify the 'type' column to have the new ENUM values
            $table->enum('type', [
                'credit', 
                'debet', 
                'class', 
                'school', 
                'package', 
                'wallet', 
                'student status', 
                'donatur status', 
                'employee status', 
                'employee category',
                'status'
            ])->default('credit')->change();  // Ensure default value is 'credit'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('options', function (Blueprint $table) {
            // Modify the 'type' column to have the new ENUM values
            $table->enum('type', [
                'credit', 
                'debet', 
                'class', 
                'school', 
                'package', 
                'wallet', 
                'student status', 
                'donatur status', 
                'employee status', 
                'employee category',
            ])->default('credit')->change();  // Ensure default value is 'credit'
        });
    }
};
