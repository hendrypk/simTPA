<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index () {
        $donatePackage = Option::where('type', Option::TYPE_PACKAGE)->get();
        $class = Option::where('type', Option::TYPE_CLASS)->get();
        $credit = Option::where('type', Option::TYPE_CREDIT)->get();
        $debit = Option::where('type', Option::TYPE_DEBIT)->get();
        $school = Option::where('type', Option::TYPE_SCHOOL)->get();
        $wallet = Option::where('type', Option::TYPE_WALLET)->get();
        return view('admin.options.index', [
            'pck' => Option::TYPE_PACKAGE,
            'crd' => Option::TYPE_CREDIT,
            'dbt' => Option::TYPE_DEBIT,
            'sch' => Option::TYPE_SCHOOL,
            'cls' => Option::TYPE_CLASS,
            'wlt' => Option::TYPE_WALLET
        ], compact('donatePackage', 'class', 'credit', 'debit', 'school', 'wallet'));
    }

    public function submit (Request $request) {
        $request->validate([
            'name' => 'required|string',
            'amount' => 'numeric'
        ], [
            'name.required' => 'Nama harus diisi',
            'amount.numeric' => 'Nominal harus berupa angka'
        ]);
        // dd($request->type);
        $type = $request->type;
        if (!in_array($type, Option::TYPES)) {
            return redirect()->back()->withErrors(['type' => 'Tipe tidak valid']);
        }

        Option::updateOrCreate([
            'id' => $request->id
        ],[
            'name' => $request->name,
            'amount' => $request->amount,
            'wallet_type' => $request->wallet_type,
            'type' => $type
        ]);

        return redirect()->back()->with('success', 'Data Berhasil Disimpan');       
    }

    public function update (Request $request) {
        $request->validate([
            'name' => 'required|string',
            'amount' => 'numeric'
        ], [
            'name.required' => 'Nama harus diisi',
            'amount.numeric' => 'Nominal harus berupa angka'
        ]);
        

        Option::updateOrCreate([
            'id' => $request->id
        ],[
            'name' => $request->name,
            'amount' => $request->amount,
            'wallet_type' => $request->wallet_type
        ]);

        return redirect()->back()->with('success', 'Data Berhasil Disimpan');       
    }

    public function delete ($id) {
        $options = Option::find($id);
        $options->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'redirect' => route('options.index')
        ]);
    }
}
