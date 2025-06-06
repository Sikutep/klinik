<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatiensController;
use App\Http\Controllers\QueuesController;
use App\Models\Patiens;
use App\Models\Role;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/csrf-token', function () {
    return ['token' => csrf_token()];
});

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    Route::resource('patiens', PatiensController::class);
    Route::post('/patiens/{id}/queues', [PatiensController::class, 'addQueue'])->name('patiens.queues');
    Route::get('/patiens/export', [QueuesController::class, 'export'])->name('patiens.export');

    Route::get('/antrian/showMonitor', [QueuesController::class, 'showMonitor'])->name('antrian.showMonitor');
    Route::post('/antrian/panggil/{id}', [QueuesController::class, 'calledQueue'])->name('antrian.panggil');
    Route::resource('antrian', QueuesController::class);
    Route::get('/queues/export', [QueuesController::class, 'export'])->name('queues.export');

    // Pastikan Anda punya method showNotes() di MedicalRecordController
    Route::get('/medicalrecord/notes', [MedicalRecordController::class, 'showNotes'])
        ->name('medicalrecord.notes');
    Route::resource('medicalrecord', MedicalRecordController::class);
});



Route::middleware('auth')->group(function () {
    Route::get('/observation/export', [ObservationController::class, 'exportExcel'])->name('observation.export');
    Route::resource('/observation', ObservationController::class);
});


Route::get('/cashier', function () {
    return view('kasir.index');
});
