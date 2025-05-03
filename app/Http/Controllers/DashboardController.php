<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Trait\DashboardTrait;

class DashboardController
{
    use DashboardTrait;

    public function index(Request $request)
    {
        // Ambil tanggal dari request atau default ke bulan ini
        $range = str_replace('+', ' ', $request->input('date_range'));
        $start = now()->startOfMonth()->toDateString();
        $end = now()->endOfMonth()->toDateString();

        if ($range && str_contains($range, 'to')) {
            [$startParsed, $endParsed] = explode(' to ', $range);
            if ($startParsed && $endParsed) {
                $start = trim($startParsed);
                $end = trim($endParsed);
            }
        }

        // Kirim tanggal ke trait
        $trx = $this->transactionSummary($start, $end);
        $contact = $this->contactSummary($start, $end);

        // Get donations, filter by date
        $donateChart = Transaction::where('type', Transaction::TYPE_DONOR)
            ->whereNull('deleted_at')
            // ->whereBetween('transaction_at', [$start, $end])
            ->get();

        // Group by short month name (Jan, Feb, ...)
        $donationPerMonth = $donateChart->groupBy(function ($item) {
            return Carbon::parse($item->transaction_at)->format('M');
        })->map(function ($group) {
            return $group->sum('amount');
        });

        // Define all months
        $allMonths = [
            'Jan' => 'January', 'Feb' => 'February', 'Mar' => 'March', 'Apr' => 'April', 'May' => 'May',
            'Jun' => 'June', 'Jul' => 'July', 'Aug' => 'August', 'Sep' => 'September', 'Oct' => 'October',
            'Nov' => 'November', 'Dec' => 'December'
        ];

        // Get full month names
        $month = array_values($allMonths);

        // Get donation data per month, fill 0 if missing
        $donate = array_map(function ($shortMonth) use ($donationPerMonth) {
            return $donationPerMonth->get($shortMonth, 0);
        }, array_keys($allMonths));

        return view('admin.index', compact('trx', 'contact', 'month', 'donate'));
    }
}
