<?php
namespace App\Trait;

use App\Models\Contact;
use App\Models\Transaction;
use Carbon\Carbon;

trait DashboardTrait
{
    /**
     * Get transaction summary with optional date range filter
     * 
     * @param string|null $startDate
     * @param string|null $endDate
     * @return array
     */
    public function transactionSummary($startDate = null, $endDate = null)
    {
        // If date range is provided, filter transactions by the range
        $query = Transaction::whereNull('deleted_at');

        if ($startDate && $endDate) {
            $query->whereBetween('transaction_at', [Carbon::parse($startDate), Carbon::parse($endDate)]);
        }

        $totalDonate = (clone $query)->where('type', Transaction::TYPE_DONOR)->sum('amount');
        $totalDebet = (clone $query)->where('type', Transaction::TYPE_DEBET)->sum('amount');
        $totalCredit = (clone $query)->where('type', Transaction::TYPE_CREDIT)->sum('amount');
        $totalTransfer = (clone $query)->where('type', Transaction::TYPE_TRANSFER)->sum('amount');

        // Remaining diambil dari semua transaksi tanpa filter tanggal
        $baseQuery = Transaction::whereNull('deleted_at');
        $totalDebetAll = (clone $baseQuery)->where('type', Transaction::TYPE_DEBET)->sum('amount');
        $totalDonateAll = (clone $baseQuery)->where('type', Transaction::TYPE_DONOR)->sum('amount');
        $totalCreditAll = (clone $baseQuery)->where('type', Transaction::TYPE_CREDIT)->sum('amount');

        $remaining = $totalDebetAll + $totalDonateAll - $totalCreditAll;

        return [
            'total_debet' => $totalDebet,
            'total_credit' => $totalCredit,
            'total_donate' => $totalDonate,
            'total_transfer' => $totalTransfer,
            'remaining' => $remaining,
        ];
    }

    /**
     * Get contact summary with optional date range filter
     * 
     * @param string|null $startDate
     * @param string|null $endDate
     * @return array
     */
    public function contactSummary($startDate = null, $endDate = null)
    {
        $query = Contact::query();

        $totalStudent = (clone $query)->where('type', Contact::TYPE_STUDENT)->count();
        $totalDonor = (clone $query)->where('type', Contact::TYPE_DONOR)->count();
        $totalEmployee = (clone $query)->where('type', Contact::TYPE_EMPLOYEE)->count();
        $totalVendor = (clone $query)->where('type', Contact::TYPE_VENDOR)->count();

        return [
            'total_student' => $totalStudent,
            'total_donor' => $totalDonor,
            'total_employee' => $totalEmployee,
            'total_vendor' => $totalVendor,
        ];
    }
}

// namespace App\Trait;

// use App\Models\Contact;
// use App\Models\Transaction;

// trait DashboardTrait
// {
//     /**
//      * Get transaction
//      * 
//      * @return array
//      */

//      public function transactionSummary () {
//         $totalDonate = Transaction::where('type', Transaction::TYPE_DONOR)->whereNull('deleted_at')->sum('amount');
//         $totalDebet = Transaction::where('type', Transaction::TYPE_DEBET)->whereNull('deleted_at')->sum('amount');
//         $totalCredit = Transaction::where('type', Transaction::TYPE_CREDIT)->whereNull('deleted_at')->sum('amount');
//         $totalTransfer = Transaction::where('type', Transaction::TYPE_TRANSFER)->sum('amount');
//         $remaining = $totalDebet + $totalDonate - $totalCredit;

//         return [
//             'total_debet' => $totalDebet,
//             'total_credit' => $totalCredit,
//             'total_donate' => $totalDonate,
//             'total_transfer' => $totalTransfer,
//             'remaining' => $remaining,
//         ];
//      }

//      public function contactSummary () {
//         $totalStudent = Contact::where('type', Contact::TYPE_STUDENT)->count();
//         $totalDonor = Contact::where('type', Contact::TYPE_DONOR)->count();
//         $totalEmployee = Contact::where('type', Contact::TYPE_EMPLOYEE)->count();
//         $totalVendor = Contact::where('type', Contact::TYPE_VENDOR)->count();

//         return [
//             'total_student' => $totalStudent,
//             'total_donor' => $totalDonor,
//             'total_employee' => $totalEmployee,
//             'total_vendor' => $totalVendor,
//         ];
//      }
// }
