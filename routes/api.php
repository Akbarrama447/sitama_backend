<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TugasAkhirController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/



// --- Rute Publik (Bisa diakses tanpa Login) ---
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user(); // Ini akan mengembalikan JSON user yang sedang login
});

Route::middleware('auth:sanctum')->get('/mahasiswa', function (Request $request) {
    $user = $request->user();
    
    // 1. Cari data diri kamu di tabel mahasiswa berdasarkan user_id login
    $mhsLogin = DB::table('mahasiswa')->where('user_id', $user->id)->first();
    
    if (!$mhsLogin) {
        return response()->json([]);
    }

    // 2. Ambil teman yang prodi_id nya SAMA dengan kamu (misal sama-sama kode 1/2/3)
    // dan jangan munculkan nama kamu sendiri di daftar bursa anggota
    return DB::table('mahasiswa')
        ->where('prodi_id', $mhsLogin->prodi_id)
        ->where('mhs_nim', '!=', $mhsLogin->mhs_nim)
        ->get(['mhs_nim', 'mhs_nama']);
});
// --- Rute Terproteksi (Harus kirim Token/Bearer) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // Profil & Password
    Route::get('/profil', [AuthController::class, 'profile']);
    Route::post('/ganti-password', [AuthController::class, 'updatePassword']);

    // Tugas Akhir (SITAMA Project)
    Route::get('/tugas-akhir', [TugasAkhirController::class, 'index']); // getThesis
    Route::post('/tugas-akhir', [TugasAkhirController::class, 'store']); // createThesis
    Route::post('/upload-dokumen', [TugasAkhirController::class, 'upload']);
    
    Route::middleware('auth:sanctum')->get('/check-sidang-eligibility', [BimbinganController::class, 'checkSidangEligibility']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});