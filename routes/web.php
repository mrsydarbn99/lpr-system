<?php

use App\Models\NonResident;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NonResidentController;
use App\Http\Controllers\TransactionsController;

Route::get('/', function () { return view('welcome'); })->name('welcome');

Route::middleware([AdminMiddleware::class])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('resident-list', [ResidentController::class, 'index'])->name('resident-list');
    Route::get('resident-create', [ResidentController::class, 'create'])->name('resident-create');
    Route::post('resident-store', [ResidentController::class, 'store'])->name('resident-store');
    Route::get('resident-edit/{id}', [ResidentController::class, 'edit'])->name('resident-edit');
    Route::put('resident-update/{id}', [ResidentController::class, 'update'])->name('resident-update');
    Route::delete('resident-delete/{id}', [ResidentController::class, 'destroy'])->name('resident-delete');

    Route::get('non-resident-list', [NonResidentController::class, 'index'])->name('non-resident-list');
    Route::get('non-resident-create', [NonResidentController::class, 'create'])->name('non-resident-create');
    Route::get('non-resident-edit/{id}', [NonResidentController::class, 'edit'])->name('non-resident-edit');
    Route::put('non-resident-update/{id}', [NonResidentController::class, 'update'])->name('non-resident-update');
    Route::delete('non-resident-delete/{id}', [NonResidentController::class, 'destroy'])->name('non-resident-delete');

    Route::get('transactions-list', [TransactionsController::class, 'index'])->name('transactions-list');

    Route::get('user-list', [UserController::class, 'index'])->name('user-list');
    Route::get('user-create', [UserController::class, 'create'])->name('user-create');
    Route::post('user-store', [UserController::class, 'store'])->name('user-store');
    Route::get('user-edit/{id}', [UserController::class, 'edit'])->name('user-edit');
    Route::put('user-update/{id}', [UserController::class, 'update'])->name('user-update');
    Route::delete('user-delete/{id}', [UserController::class, 'destroy'])->name('user-delete');

    Route::get('scan', [VideoController::class, 'index'])->name('scan');
    Route::post('scan/video', [VideoController::class, 'startScan'])->name('scan-video');
    // Route::post('scan/stop', [VideoController::class, 'stopScan'])->name('stop.scan');
    // Route::get('scan', function () { return view('scan'); })->name('scan');
});

// Route::get('/upload', [VideoController::class, 'showUploadForm'])->name('upload.form');
// Route::post('/upload', [VideoController::class, 'uploadVideo'])->name('upload.video');



Route::get('registration', [NonResidentController::class, 'registration'])->name('register');
Route::post('non-resident-store', [NonResidentController::class, 'store'])->name('non-resident-store');

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
