<?php

use App\Http\Controllers\NonResidentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ResidentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('resident-list', [ResidentController::class, 'index'] )->name('resident-list');
Route::get('resident-create', [ResidentController::class, 'create'])->name('resident-create');
Route::post('resident-store', [ResidentController::class, 'store'])->name('resident-store');
Route::get('resident-edit/{id}', [ResidentController::class, 'edit'])->name('resident-edit');
Route::put('resident-update/{id}', [ResidentController::class, 'update'])->name('resident-update');
Route::delete('resident-delete/{id}', [ResidentController::class, 'destroy'])->name('resident-delete');

Route::get('non-resident-list', [NonResidentController::class, 'index'] )->name('non-resident-list');
Route::get('non-resident-create', [NonResidentController::class, 'create'])->name('non-resident-create');
Route::post('non-resident-store', [NonResidentController::class, 'store'])->name('non-resident-store');
Route::get('non-resident-edit/{id}', [NonResidentController::class, 'edit'])->name('non-resident-edit');
Route::put('non-resident-update/{id}', [NonResidentController::class, 'update'])->name('non-resident-update');
Route::delete('non-resident-delete/{id}', [NonResidentController::class, 'destroy'])->name('non-resident-delete');


Route::get('/scan', function () {
    return view('scan');
});

// Route::get('/upload', [VideoController::class, 'showUploadForm'])->name('upload.form');
// Route::post('/upload', [VideoController::class, 'uploadVideo'])->name('upload.video');

Route::post('/scan/video', [VideoController::class, 'startScan'])->name('scan.video');
Route::post('/scan/stop', [VideoController::class, 'stopScan'])->name('stop.scan');
