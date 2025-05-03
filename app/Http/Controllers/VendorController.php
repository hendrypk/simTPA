<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Option;
use App\Models\Contact;
use App\Models\Transaction;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index() {
        $vendors = Contact::with('statuses')->where('type', Contact::TYPE_VENDOR)->get();
        $status = Option::where('type', Option::TYPE_STATUS)->get();
        return view('admin.vendor.index', compact('vendors', 'status'));
    }

    public function submit(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'whatsapp' => 'required',
            'address' => 'required|string',
            'register_date' => 'required|date',
            'status' => 'required'
        ]);

        $year = Carbon::now()->year; // Tahun sekarang (4 digit)
        $yearShort = substr($year, -2); // Ambil 2 digit terakhir
    
        $latestCid = Contact::where('type', Contact::TYPE_VENDOR)
            ->whereNotNull('cid')
            ->whereRaw("cid REGEXP '^D[0-9]{2}[0-9]{3}[0-9]{3}$'")
            ->orderByDesc('cid')
            ->value('cid');

        $totalAll = 1;
        $totalThisYear = 1;

        if ($latestCid) {
            $totalAll = (int) substr($latestCid, 3, 3) + 1;
            $totalThisYear = (int) substr($latestCid, 6, 3) + 1;
        }
        
        $totalAllFormatted = str_pad($totalAll, 3, '0', STR_PAD_LEFT);
        $totalThisYearFormatted = str_pad($totalThisYear, 3, '0', STR_PAD_LEFT);
        
        $cid = 'V' . $yearShort . $totalAllFormatted . $totalThisYearFormatted;

        $vendor = Contact::firstOrNew(['id' => $request->id]);

        if (!$vendor->exists) {
            $vendor->cid = $cid; // hanya di-set saat record baru
        }

        $vendor->fill([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
            'address' => $request->address,
            'register_date' => $request->register_date,
            'status_id' => $request->status,
            'type' => Contact::TYPE_VENDOR,
        ]);

        $vendor->save();

        return redirect()->back()->with('success', 'Data Berhasil Disimpan');   
    }

    public function delete($id) {
        $exist = Transaction::where('related_id', $id)->exists();
        if ($exist) {
            return response()->json([
                'success' => false,
                'message' => 'Ada transaksi dari Vendor tersebut, tidak bisa dihapus!',
                'redirect' => route('options.index')
            ]);
        }
        $student = Contact::find($id);
        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'redirect' => route('student.index')
        ]);
    }
}
