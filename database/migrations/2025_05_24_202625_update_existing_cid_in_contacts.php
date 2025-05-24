<?php

use Carbon\Carbon;
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
        Schema::table('contacts', function (Blueprint $table) {
            $students = DB::table('contacts')
                ->where('type', 'student')
                ->whereNotNull('cid')
                ->orderBy('id')
                ->get();

            $year = Carbon::now()->year;
            $yearShort = substr($year, -2);

            $totalAll = 1;
            $totalThisYear = 1;

            foreach ($students as $student) {
                $totalAllFormatted = str_pad($totalAll, 3, '0', STR_PAD_LEFT);
                $totalThisYearFormatted = str_pad($totalThisYear, 3, '0', STR_PAD_LEFT);
                $cid = 'S' . $yearShort . $totalAllFormatted . $totalThisYearFormatted;

                DB::table('contacts')
                    ->where('id', $student->id)
                    ->update(['cid' => $cid]);

                $totalAll++;
                $totalThisYear++;
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
        DB::table('contacts')
            ->where('type', 'student')
            ->update(['cid' => 'S25001001']);
        });
    }
};
