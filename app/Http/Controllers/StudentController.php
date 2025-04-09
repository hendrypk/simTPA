<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Option;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index() {
        $students = Student::with('class', 'school')->get();
        $class = Option::where('type', 'class')->get(['id', 'name']);
        $school = Option::where('type', 'school')->get(['id', 'name']);
        return view('admin.student.index', compact('students', 'class', 'school'));
    }

    public function submit(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'place_birth' => 'required|string',
            'date_birth' => 'required|date',
            'class_id' => 'required|integer',
            'father_name' => 'required|string',
            'parent_number' => 'required|string',
            'register_date' => 'required|date',
            'school_id' => 'required|integer',
        ]);

        $year = Carbon::now()->year; // Tahun sekarang (4 digit)
        $yearShort = substr($year, -2); // Ambil 2 digit terakhir
    
        $totalAll = Student::whereNull('deleted_at')->count(); // Semua santri
        $totalThisYear = Student::whereYear('register_date', $year)->whereNull('deleted_at')->count(); // Santri tahun ini
    
        // Format angka jadi 3 digit (pakai str_pad)
        $totalAllFormatted = str_pad($totalAll, 3, '1', STR_PAD_LEFT);
        $totalThisYearFormatted = str_pad($totalThisYear, 3, '1', STR_PAD_LEFT);
    
        $nis = $yearShort . $totalAllFormatted . $totalThisYearFormatted;
        // dd($request->id);
        Student::updateOrCreate([
            'id' => $request->id
        ], [
            'nis' => $nis,
            'name' => $request->name,
            'place_birth' => $request->place_birth,
            'date_birth' => $request->date_birth,
            'class_id' => $request->class_id,
            'mother_name' => $request->father_name,
            'father_name' => $request->father_name,
            'parent_number' => $request->parent_number,
            'register_date' => $request->register_date,
            'school_id' => $request->school_id,
        ]);

        return redirect()->back()->with('success', 'Data Berhasil Disimpan');   
    }

    public function delete($id) {
        $student = Student::find($id);
        $student->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'redirect' => route('student.index')
        ]);
    }


}
