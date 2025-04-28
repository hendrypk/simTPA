<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('options', function (Blueprint $table) {
            DB::statement("ALTER TABLE options MODIFY COLUMN type ENUM('credit', 'debet', 'class', 'school', 'package', 'wallet', 'student status', 'donatur status', 'employee_status') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('options', function (Blueprint $table) {
            DB::statement("ALTER TABLE options MODIFY COLUMN type ENUM('credit', 'debet', 'class', 'school', 'package', 'wallet', 'student status', 'donatur status') NOT NULL");
        });
    }
};
