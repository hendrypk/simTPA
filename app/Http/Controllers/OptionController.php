<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Option;
use App\Models\Student;
use App\Models\Transaction;
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
        $studentStatus = Option::where('type', Option::TYPE_STUDENT_STATUS)->get();
        $donaturStatus = Option::where('type', Option::TYPE_DONATUR_STATUS)->get();
        $employeeStatus = Option::where('type', Option::TYPE_EMPLOYEE_STATUS)->get();
        $employeeCategory = Option::where('type', Option::TYPE_EMPLOYEE_CATEGORY)->get();
        return view('admin.options.index', [
            'pck' => Option::TYPE_PACKAGE,
            'crd' => Option::TYPE_CREDIT,
            'dbt' => Option::TYPE_DEBIT,
            'sch' => Option::TYPE_SCHOOL,
            'cls' => Option::TYPE_CLASS,
            'wlt' => Option::TYPE_WALLET,
            'std_sts' => Option::TYPE_STUDENT_STATUS,
            'dnt_sts' => Option::TYPE_DONATUR_STATUS,
            'emp_sts' => Option::TYPE_EMPLOYEE_STATUS,
            'emp_ctg' => Option::TYPE_EMPLOYEE_CATEGORY,
        ], compact(
            'donatePackage',
            'class',
            'credit',
            'debit',
            'school',
            'wallet',
            'studentStatus',
            'donaturStatus',
            'employeeStatus',
            'employeeCategory'));
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

    public function delete($id) {
        $options = Option::find($id);
    
        $status = Contact::where('status_id', $id)->exists();
        $schoolUsed = Contact::where('school_id', $id)->exists();
        $classUsed = Contact::where('class_id', $id)->exists();
        $donatePackage = Contact::where('package_id', $id)->exists();
        $wallet = Transaction::where('wallet_id', $id)->exists();
        $trx_category = Transaction::where('payable_id', $id)->exists();
        $employeeCategory = Contact::where('employee_category_id')->exists();
    
        if ($status || $schoolUsed || $classUsed || $donatePackage || $wallet || $trx_category || $employeeCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang sudah digunakan, tidak bisa dihapus!',
                'redirect' => route('options.index')
            ]);
        }
    
        $options->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus!',
            'redirect' => route('options.index')
        ]);
    }
    
}
