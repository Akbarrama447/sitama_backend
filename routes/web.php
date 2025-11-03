<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\SidangController;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/dosen/sidang', [SidangController::class, 'index'])->name('dosen.sidang');


    // Page Mahasiswa Bimbingan
    Route::get('/dosen/bimbingan', [BimbinganController::class, 'index'])
        ->name('dosen.bimbingan');

    // Tombol approve
    Route::post('/bimbingan/{id}/approve', [BimbinganController::class, 'approve'])
        ->name('bimbingan.approve');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
