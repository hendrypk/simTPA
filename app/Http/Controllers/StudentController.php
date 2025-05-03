<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Option;
use App\Models\Contact;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index() {
        $students = Contact::with('classes', 'schools', 'statuses')->where('type', Contact::TYPE_STUDENT)->get();
        // dd($students);
        $class = Option::where('type', Option::TYPE_CLASS)->get();
        $school = Option::where('type', Option::TYPE_SCHOOL)->get();
        $status = Option::where('type', Option::TYPE_STATUS)->get();
        return view('admin.student.index', compact('students', 'class', 'school', 'status'));
    }

    public function submit(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'place_birth' => 'required|string',
            'date_birth' => 'required|date',
            'class_id' => 'required|integer',
            'guardian_name' => 'required|string',
            'guardian_number' => 'required|string',
            'register_date' => 'required|date',
            'school_id' => 'required|integer',
        ]);

        $year = Carbon::now()->year; // Tahun sekarang (4 digit)
        $yearShort = substr($year, -2); // Ambil 2 digit terakhir
    
        $latestCid = Contact::where('type', Contact::TYPE_STUDENT)
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
        
        $cid = 'S' . $yearShort . $totalAllFormatted . $totalThisYearFormatted;

        $student = Contact::firstOrNew(['id' => $request->id]);

        if (!$student->exists) {
            $student->cid = $cid; // hanya di-set saat record baru
        }

        $student->fill([
            'name' => $request->name,
            'address' => $request->address,
            'place_birth' => $request->place_birth,
            'date_birth' => $request->date_birth,
            'class_id' => $request->class_id,
            'guardian_name' => $request->guardian_name,
            'guardian_number' => $request->guardian_number,
            'register_date' => $request->register_date,
            'school_id' => $request->school_id,
            'status_id' => $request->status,
            'type' => Contact::TYPE_STUDENT,
        ]);

        $student->save();

        return redirect()->back()->with('success', 'Data Berhasil Disimpan');   
    }

    public function delete($id) {
        $exist = Transaction::where('related_id', $id)->exists();
        if ($exist) {
            return response()->json([
                'success' => false,
                'message' => 'Ada transaksi dari santri tersebut, tidak bisa dihapus!',
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

    // public function index() {
    //     $students = Student::with('class', 'school', 'statuses')->get();
    //     $class = Option::where('type', 'class')->get(['id', 'name']);
    //     $school = Option::where('type', 'school')->get(['id', 'name']);
    //     $status = Option::where('type', 'student status')->get(['id', 'name']);
    //     return view('admin.student.index', compact('students', 'class', 'school', 'status'));
    // }
    
    // public function submit(Request $request) {
    //     $request->validate([
    //         'name' => 'required|string',
    //         'place_birth' => 'required|string',
    //         'date_birth' => 'required|date',
    //         'class_id' => 'required|integer',
    //         'father_name' => 'required|string',
    //         'parent_number' => 'required|string',
    //         'register_date' => 'required|date',
    //         'school_id' => 'required|integer',
    //     ]);

    //     $year = Carbon::now()->year; // Tahun sekarang (4 digit)
    //     $yearShort = substr($year, -2); // Ambil 2 digit terakhir
    
    //     $totalAll = Student::whereNull('deleted_at')->count(); // Semua santri
    //     $totalThisYear = Student::whereYear('register_date', $year)->whereNull('deleted_at')->count(); // Santri tahun ini
    
    //     // Format angka jadi 3 digit (pakai str_pad)
    //     $totalAllFormatted = str_pad($totalAll, 3, '0', STR_PAD_LEFT);
    //     $totalThisYearFormatted = str_pad($totalThisYear, 3, '0', STR_PAD_LEFT);
    
    //     $nis = $yearShort . $totalAllFormatted . $totalThisYearFormatted;

    //     Student::updateOrCreate([
    //         'id' => $request->id
    //     ], [
    //         'nis' => $nis,
    //         'name' => $request->name,
    //         'place_birth' => $request->place_birth,
    //         'date_birth' => $request->date_birth,
    //         'class_id' => $request->class_id,
    //         'mother_name' => $request->father_name,
    //         'father_name' => $request->father_name,
    //         'parent_number' => $request->parent_number,
    //         'register_date' => $request->register_date,
    //         'school_id' => $request->school_id,
    //         'status' => $request->status,
    //     ]);

    //     return redirect()->back()->with('success', 'Data Berhasil Disimpan');   
    // }

    // public function delete($id) {
    //     $student = Student::find($id);
    //     $student->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Data berhasil dihapus',
    //         'redirect' => route('student.index')
    //     ]);
    // }


}
