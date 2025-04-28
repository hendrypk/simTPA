<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('admin.index');
// })->name('dashboard');

Route::get('', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('options')->group(function () {
    Route::get('', [OptionController::class, 'index'])->name('options.index');
    Route::post('/submit', [OptionController::class, 'submit'])->name('options.submit');
    Route::post('/update', [OptionController::class, 'update'])->name('options.update');
    Route::post('{id}/delete', [OptionController::class, 'delete'])->name('options.delete');
});

Route::prefix('students')->group(function () {
    Route::get('', [StudentController::class, 'index'])->name('student.index');        
    Route::post('submit', [StudentController::class, 'submit'])->name('student.submit');
    Route::post('{id}/delete', [StudentController::class, 'delete'])->name('student.delete');
});

Route::prefix('donors')->group(function () {
    Route::get('', [DonorController::class, 'index'])->name('donors.index');
    Route::post('submit', [DonorController::class, 'submit'])->name('donors.submit');
    Route::post('{id}/delete', [DonorController::class, 'delete'])->name('donors.delete');
});

Route::prefix('employees')->group(function () {
    Route::get('', [EmployeeController::class, 'index'])->name('employees.index');
    Route::post('submit', [EmployeeController::class, 'submit'])->name('employees.submit');
    Route::post('{id}/delete', [EmployeeController::class, 'delete'])->name('employees.delete');
});

Route::prefix('transactions')->group(function () {
    Route::get('', [TransactionController::class, 'index'])->name('trx.index');
    Route::post('submit', [TransactionController::class, 'submit'])->name('trx.submit');
    Route::post('{id}/delete', [TransactionController::class, 'delete'])->name('trx.delete');
    Route::get('/donor', [TransactionController::class, 'indexDonor'])->name('trx.donor.index');
    Route::post('/donor/submit', [TransactionController::class, 'submitDonor'])->name('trx.donor.submit');
});