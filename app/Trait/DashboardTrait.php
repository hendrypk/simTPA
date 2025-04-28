<?php

namespace App\Trait;

use App\Models\Contact;
use App\Models\Transaction;

trait DashboardTrait
{
    /**
     * Get transaction
     * 
     * @return array
     */

     public function transactionSummary () {
        $totalDonate = Transaction::where('type', Transaction::TYPE_DONOR)->whereNull('deleted_at')->sum('amount');
        $totalDebet = Transaction::where('type', Transaction::TYPE_DEBET)->whereNull('deleted_at')->sum('amount');
        $totalCredit = Transaction::where('type', Transaction::TYPE_CREDIT)->whereNull('deleted_at')->sum('amount');
        $totalTransfer = Transaction::where('type', Transaction::TYPE_TRANSFER)->sum('amount');
        $remaining = $totalDebet + $totalDonate - $totalCredit;

        return [
            'total_debet' => $totalDebet,
            'total_credit' => $totalCredit,
            'total_donate' => $totalDonate,
            'total_transfer' => $totalTransfer,
            'remaining' => $remaining,
        ];
     }

     public function contactSummary () {
        $totalStudent = Contact::where('type', Contact::TYPE_STUDENT)->count();
        $totalDonor = Contact::where('type', Contact::TYPE_DONOR)->count();
        $totalEmployee = Contact::where('type', Contact::TYPE_EMPLOYEE)->count();
        $totalVendor = Contact::where('type', Contact::TYPE_VENDOR)->count();

        return [
            'total_student' => $totalStudent,
            'total_donor' => $totalDonor,
            'total_employee' => $totalEmployee,
            'total_vendor' => $totalVendor,
        ];
     }
}
