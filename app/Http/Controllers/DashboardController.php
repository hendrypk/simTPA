<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Trait\DashboardTrait;

class DashboardController
{
    use DashboardTrait;

    public function index()
    {
        $trx = $this->transactionSummary();
        $contact = $this->contactSummary();
        
        $donateChart = Transaction::where('type', Transaction::TYPE_DONOR)
            ->whereNull('deleted_at')
            ->get();

        // Grouping by month and calculating the total donations per month
        $donationPerMonth = $donateChart->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('M'); // 'M' gives the abbreviated month name (Jan, Feb, ...)
        })->map(function ($month) {
            return $month->sum('amount');  // Summing up the donations for each month
        });

        // Full month names for labels
        $allMonths = [
            'Jan' => 'January', 'Feb' => 'February', 'Mar' => 'March', 'Apr' => 'April', 'May' => 'May',
            'Jun' => 'June', 'Jul' => 'July', 'Aug' => 'August', 'Sep' => 'September', 'Oct' => 'October',
            'Nov' => 'November', 'Dec' => 'December'
        ];

        // Prepare the labels and data to ensure all months are included
        $month = array_values($allMonths);  // Get the full month names as labels

        // Prepare the data (total donations per month), ensuring missing months are filled with 0
        $donate = array_map(function ($month) use ($donationPerMonth) {
            return $donationPerMonth->get($month, 0);  // Return the sum for the month or 0 if no data
        }, array_keys($allMonths));

        return view('admin.index', compact('trx', 'contact', 'month', 'donate'));
    }
}
