<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Option;
use App\Models\Contact;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index () {
        $employees = Contact::with('statuses', 'employee_category')->where('type', Contact::TYPE_EMPLOYEE)->get();
        $category = Option::where('type', 'employee category')->get();
        $status = Option::where('type', 'employee status')->get();
        return view('admin.employee.index', compact('employees', 'category', 'status'));
    }

    public function submit (Request $request) {
        $request->validate([
            'name' => 'required',
            'whatsapp' => 'required',
            'register_date' => 'required|date',
            'category' => 'required',
            'status' => 'required'
        ]);

        $year = Carbon::now()->year; 
        $yearShort = substr($year, -2);
    
        $latestCid = Contact::where('type', Contact::TYPE_EMPLOYEE)
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
        
        $cid = 'K' . $yearShort . $totalAllFormatted . $totalThisYearFormatted;

        $employee = Contact::firstOrNew(['id' => $request->id]);

        if (!$employee->exists) {
            $employee->cid = $cid; 
        }

        $employee->fill([
            'name' => $request->name,
            'address' => $request->address,
            'whatsapp' => $request->whatsapp,
            'register_date' => $request->register_date,
            'employee_category_id' => $request->category,
            'status_id' => $request->status,
            'type' => Contact::TYPE_EMPLOYEE
        ]);

        $employee->save();
    
        return redirect()->back()->with('success', 'Data karyawan berhasil disimpan');
    }

    public function delete($id) {
        $employee = Contact::find($id);
        $employee->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data karyawan berhasil dihapus',
            'redirect' => route('employees.index')
        ]);
    }

    // public function index () {
    //     $employees = Employee::with('statuses', 'category')->get();
    //     $category = Option::where('type', 'employee category')->get();
    //     $status = Option::where('type', 'employee status')->get();
    //     return view('admin.employee.index', compact('employees', 'category', 'status'));
    // }

    // public function submit (Request $request) {
    //     $request->validate([
    //         'name' => 'required',
    //         'whatsapp' => 'required',
    //         'register_date' => 'required|date',
    //         'category' => 'required',
    //         'status' => 'required'
    //     ]);
        
    //     Employee::updateOrCreate(
    //         ['id' => $request->id],
    //         [
    //             'name' => $request->name,
    //             'whatsapp' => $request->whatsapp,
    //             'register_date' => $request->register_date,
    //             'category_id' => $request->category,
    //             'status' => $request->status
    //         ]
    //     );
        
    //     return redirect()->back()->with('success', 'Data karyawan berhasil disimpan');
    // }

    // public function delete($id) {
    //     $employee = Employee::find($id);
    //     $employee->delete();
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Data karyawan berhasil dihapus',
    //         'redirect' => route('employees.index')
    //     ]);
    // }
}
