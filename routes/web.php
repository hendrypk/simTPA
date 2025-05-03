<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('admin.index');
// })->name('dashboard');

Route::middleware('guest')->group(function() {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login/auth', [AuthController::class, 'login'])->name('login.auth');
    
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
    Route::post('/forgot-password/reset-link', [AuthController::class, 'resetLink'])->name('password.reset.link');
    Route::get('/password-reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password-reset', [AuthController::class, 'resetPassword'])->name('password.update');

});

// Route::post('password-reset-request', [AuthController::class, 'sendResetToken'])->name('password.reset.request');
// Route::get('password-reset', [AuthController::class, 'showResetForm'])->name('password.reset.form');
// Route::post('password-reset', [AuthController::class, 'resetPassword'])->name('password.reset');



Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

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

    Route::prefix('vendors')->group(function () {
        Route::get('', [VendorController::class, 'index'])->name('vendor.index');
        Route::post('submit', [VendorController::class, 'submit'])->name('vendor.submit');
        Route::post('{id}/delete', [VendorController::class, 'delete'])->name('vendor.delete');
    });

    Route::prefix('transactions')->group(function () {
        Route::get('', [TransactionController::class, 'index'])->name('trx.index');
        Route::post('submit', [TransactionController::class, 'submit'])->name('trx.submit');
        Route::post('{id}/delete', [TransactionController::class, 'delete'])->name('trx.delete');
        Route::get('/donor', [TransactionController::class, 'indexDonor'])->name('trx.donor.index');
        Route::post('/donor/submit', [TransactionController::class, 'submitDonor'])->name('trx.donor.submit');
        Route::get('/report', [TransactionController::class, 'transactionReport'])->name('trx.report');
    });

    Route::prefix('role')->group(function () {
        Route::get('', [RoleController::class, 'index'])->name('roles.index');
        Route::get('create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('create/store', [RoleController::class, 'store'])->name('roles.store');
        Route::get('{id}/detail', [RoleController::class, 'detail'])->name('roles.detail');
        Route::post('{id}/delete', [RoleController::class, 'roleDelete'])->name('roles.delete');        
        Route::post('{id}/submit', [RoleController::class, 'submit'])->name('roles.submit');
    });

    Route::prefix('user')->group(function () {
        Route::post('submit', [RoleController::class, 'storeUser'])->name('user.submit');
        Route::post('{id}/delete', [RoleController::class, 'userDelete'])->name('user.delete');        
    });

    Route::prefix('account')->group(function () {
        Route::get('', [AuthController::class, 'edit'])->name('account.edit');
        Route::put('/update', [AuthController::class, 'update'])->name('account.update');
        Route::post('/profile/upload', [AuthController::class, 'uploadProfileImage'])->name('profile.upload');

    });

});

