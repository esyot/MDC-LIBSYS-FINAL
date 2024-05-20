<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\TimeinController;
use App\Http\Controllers\TimeoutController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CSVController;

Route::get('/', function () {
    return view('main');
});

Route::get('/monitor', [IndexController::class, 'monitor'])->name('monitor');

Route::get('/timein', [IndexController::class, 'timein'])->name('timein');
Route::get('/timeout', [IndexController::class, 'timeout'])->name('timeout');
Route::get('/register', [IndexController::class, 'register'])->name('register');
Route::get('/dashboard', [IndexController::class, 'dashboard'])->name('dashboard');
Route::get('/students', [IndexController::class, 'students'])->name('students');
Route::get('/student/{id}', [StudentController::class, 'show'])->name('students.show');
Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');


Route::delete('/delete/{id}', [StudentController::class, 'delete'])->name('delete');

Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');

Route::post('/students/store', [StudentController::class, 'store'])->name('students.store');

Route::get('/students/pdf', [StudentController::class, 'generatePDF'])->name('students.pdf');

Route::post('/process-qr-code', [TimeinController::class, 'processQRCode']);
Route::post('/process-qr-code-timeout', [TimeoutController::class, 'processQRCode']);

// Routes for CSV functionality
Route::get('/csv', [IndexController::class, 'csv'])->name('csv');
Route::get('/importcsv', [IndexController::class, 'importcsv'])->name('importcsv');

//import to database
Route::post('/generatecsv', [CSVController::class, 'generateCSV'])->name('generatecsv');

Route::post('/import', [CSVController::class, 'import'])->name('import');
    

Route::get('/timein/pdf', [TimeinController::class, 'generatePDF'])->name('timeinpdf');


Route::get('/timeout/pdf', [TimeoutController::class, 'generatePDF'])->name('timeoutpdf');

Route::get('/students/generatecsv', [StudentController::class, 'generateCsv']);
