<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Donor;
use App\Models\Option;
use App\Models\Contact;
use App\Models\Student;
use App\Models\Employee;
use App\Models\Transaction;
use App\Trait\DashboardTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    use DashboardTrait;

    public function index (Request $request) {
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
        $trxs = $this->transactionSummary($start, $end);

        $trx = Transaction::where('is_donor', false)->with('payable', 'wallet', 'employee')->get();
        $trxDonor = Transaction::where('is_donor', true)->with('payable', 'wallet', 'employee')->get();
        $wallet = Option::where('type', 'wallet')->get();
        $outTrx = Option::where('type', Option::TYPE_CREDIT)->get();
        $inTrx = Option::where('type', Option::TYPE_DEBIT)->get();

        $employee = Contact::where('type', Contact::TYPE_EMPLOYEE)->get();
        $student = Contact::where('type', Contact::TYPE_STUDENT)->get();
        $donor = Contact::where('type', Contact::TYPE_DONOR)->get();

        return view('admin.transaction.index', compact('trxs', 'trx', 'wallet', 'outTrx', 'inTrx', 'employee', 'student', 'donor'));
    }

    public function indexDonor () {
        $trx = Transaction::where('is_donor', true)->with('payable', 'wallet', 'employee')->get();
        $wallet = Option::where('type', 'wallet')->get();
        $donor = Contact::where('type', Contact::TYPE_DONOR)->get();

        return view('admin.transaction.index_donor', compact('trx', 'wallet', 'donor'));
    }

    public function submit (Request $request) {
        $validated = $request->validate([
            'type' => 'required|in:credit,debet,transfer',
            'date' => 'required|date',
            'wallet' => 'required|exists:options,id', 
            'trx_category' => 'required|exists:options,id',
            'amount' => 'required|numeric|min:0',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'meta' => 'nullable|string',
            'recipient_category' => 'required|in:employee,donor,student',
            'related_id' => 'nullable|exists:contacts,id',
        ]);

        if($request->type == Transaction::TYPE_DEBET) {
            $txid = Transaction::dbid();
        } elseif ($request->type == Transaction::TYPE_CREDIT) {
            $txid = Transaction::crid();
        } elseif ($request->type == Transaction::TYPE_TRANSFER) {
            $txid = Transaction::tfid();
        }

        // Set the base transaction data
        $transactionData = [
            'type' => $validated['type'],
            'transaction_id' => $txid,
            'transaction_at' => $validated['date'],
            'related_id' => $request->related_id,
            'wallet_id' => $validated['wallet'],
            'payable_id' => $validated['trx_category'],
            'amount' => $validated['amount'],
            'meta' => $validated['meta'],
            'attachment' => $request->hasFile('attachment') ? $request->file('attachment')->store('attachments', 'public') : null,
        ];

        // Create or update the transaction
        $transaction = Transaction::updateOrCreate(
            ['id' => $request->input('id')], // If editing, use ID to update, else create a new record
            $transactionData
        );

        // Attach the file using Media Library (if there is a file)
        if ($request->hasFile('attachment')) {
            $transaction->addMediaFromRequest('attachment')
                ->toMediaCollection('transactions'); // 'attachments' is the name of the collection
        }
        return redirect()->route('trx.index');
    }

    public function submitDonor (Request $request) {
        $validated = $request->validate([
            'date' => 'required|date',
            'wallet' => 'required|exists:options,id', 
            'amount' => 'required|numeric|min:0',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'meta' => 'nullable|string',
            'related_id' => 'nullable|exists:contacts,id',
        ]);

        // Set the base transaction data
        $transactionData = [
            'type' => Transaction::TYPE_DONOR,
            'transaction_id' => Transaction::dnid(),
            'transaction_at' => $validated['date'],
            'related_id' => $request->related_id,
            'wallet_id' => $validated['wallet'],
            'amount' => $validated['amount'],
            'meta' => $validated['meta'],
            'is_donor' => true,
            'attachment' => $request->hasFile('attachment') ? $request->file('attachment')->store('attachments', 'public') : null,
        ];

        // Create or update the transaction
        $transaction = Transaction::updateOrCreate(
            ['id' => $request->input('id')], // If editing, use ID to update, else create a new record
            $transactionData
        );

        // Attach the file using Media Library (if there is a file)
        if ($request->hasFile('attachment')) {
            $transaction->addMediaFromRequest('attachment')
                ->toMediaCollection('transactions'); // 'attachments' is the name of the collection
        }
        return redirect()->route('trx.donor.index');
    }

    public function delete ($id) {
        $trx = Transaction::find($id);
        $trx->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data transaksi berhasil dihapus',
            'redirect' => route('trx.index')
        ]);
    }

    public function transactionReport() {
        $allMonths = [
            'Jan' => 'January', 'Feb' => 'February', 'Mar' => 'March', 'Apr' => 'April',
            'May' => 'May', 'Jun' => 'June', 'Jul' => 'July', 'Aug' => 'August',
            'Sep' => 'September', 'Oct' => 'October', 'Nov' => 'November', 'Dec' => 'December'
        ];
    
        // Ambil data transaksi untuk tahun berjalan
        $year = now()->year;
    
        $transactions = DB::table('transactions')
            ->selectRaw("DATE_FORMAT(transaction_at, '%b') as month, type, SUM(amount) as total")
            ->whereYear('transaction_at', $year)
            ->groupBy('month', 'type')
            ->get();
    
        // Siapkan array kosong per bulan
        $credit = [];
        $debet = [];
        $transfer = [];
    
        foreach ($allMonths as $short => $full) {
            $credit[] = $transactions->firstWhere(fn($t) => $t->month === $short && $t->type === 'credit')?->total ?? 0;
            $debet[] = $transactions->firstWhere(fn($t) => $t->month === $short && $t->type === 'debet')?->total ?? 0;
            $transfer[] = $transactions->firstWhere(fn($t) => $t->month === $short && $t->type === 'transfer')?->total ?? 0;
        }
    
        return view('admin.transaction.report', [
            'labels' => array_values($allMonths),
            'credit' => $credit,
            'debet' => $debet,
            'transfer' => $transfer,
        ]);
    }
}
