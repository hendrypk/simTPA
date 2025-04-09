<?php

use App\Http\Controllers\OptionController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.index');
})->name('dashboard');

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
