<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Donor;
use App\Models\Option;
use App\Models\Contact;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index () {
        $donors = Contact::with('packages', 'statuses')->where('type', Contact::TYPE_DONOR)->get();
        $package = Option::where('type', Option::TYPE_PACKAGE)->get();
        $status = Option::where('type', Option::TYPE_DONATUR_STATUS)->get();
        return view('admin.donor.index', compact('donors', 'package', 'status'));
    }

    // public function index () {
    //     $donors = Donor::with('package', 'status')->get();
    //     $package = Option::where('type', Option::TYPE_PACKAGE)->get();
    //     $status = Option::where('type', Option::TYPE_DONATUR_STATUS)->get();
    //     return view('admin.donor.index', compact('donors', 'package', 'status'));
    // }

    public function submit (Request $request) {
        $request->validate([
            'name' => 'required',
            'whatsapp' => 'required|string',
            'address' => 'required|string',
            'register_date' => 'required|date',
            'package_id' => 'required|integer',
            'status' => 'required|integer'
        ]);

        $year = Carbon::now()->year; 
        $yearShort = substr($year, -2);

        $latestCid = Contact::where('type', Contact::TYPE_DONOR)
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
        
        $cid = 'D' . $yearShort . $totalAllFormatted . $totalThisYearFormatted;
        
        $donor = Contact::firstOrNew(['id' => $request->id]);

        if (!$donor->exists) {
            $donor->cid = $cid; 
        }

        $donor->fill([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
            'address' => $request->address,
            'register_date' => $request->register_date,
            'package_id' => $request->package_id,
            'status_id' => $request->status,
            'type' => Contact::TYPE_DONOR
        ]);

        $donor->save();
        
        return redirect()->back()->with('success', 'Data donatur berhasil disimpan');
    }

    public function delete($id) {
        $exist = Transaction::where('related_id', $id)->exists();
        if ($exist) {
            return response()->json([
                'success' => false,
                'message' => 'Ada transaksi dari donatur tersebut, tidak bisa dihapus!',
                'redirect' => route('options.index')
            ]);
        }
        $donors = Contact::find($id);
        $donors->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'redirect' => route('donors.index')
        ]);
    }
}
