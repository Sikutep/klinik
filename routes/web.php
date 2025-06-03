<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/antrian', function() {
    return view('antrian.index');
});

Route::get('/pendaftaran-pasien', function() {
    return view('pendaftaran-pasien.index');
});