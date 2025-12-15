<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfilController;
use App\Http\Controllers\Api\TugasAkhirController;
// --- TAMBAHKAN IMPORT INI ---
use App\Http\Controllers\Api\SyaratSidangController;
use App\Http\Controllers\Api\JadwalSidangController;
use App\Http\Controllers\Api\LogBimbinganController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
// Rute publik
Route::post('/login', [AuthController::class, 'login']);

// Rute yang dilindungi
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    // Profil
    Route::get('/profil', [ProfilController::class, 'show']);
    Route::post('/ganti-password', [ProfilController::class, 'gantiPassword']);
    
        // Endpoint untuk MEMBUAT (mengajukan) TA baru
    Route::post('/tugas-akhir', [TugasAkhirController::class, 'store']);
    // Tugas Akhir
    Route::get('/tugas-akhir', [TugasAkhirController::class, 'show']);
    // (Pake POST + _method:PUT buat ngetes form-data)

    Route::put('/tugas-akhir', [TugasAkhirController::class, 'update']);

    // --- TAMBAKAN RUTE BARU INI ---
    // Endpoint untuk upload file (e.g., draft, persetujuan)
    
    Route::post('/syarat-sidang', [SyaratSidangController::class, 'store']);

    // Jadwal Sidang (untuk Tab Home)
    Route::get('/jadwal-sidang', [JadwalSidangController::class, 'index']);

<<<<<<< Updated upstream
=======
    // Dokumen Sidang (dokumen terpisah untuk syarat sidang)
    Route::apiResource('/dokumen-sidang', DokumenSidangController::class);

    //bimbingan
>>>>>>> Stashed changes
    Route::get('/log-bimbingan', [LogBimbinganController::class, 'index']); // Lihat histori
    Route::post('/log-bimbingan', [LogBimbinganController::class, 'store']); // Tambah log baru
    //ini untuk daftar pembimbing ya (urutan), jangan dihapus
    Route::get('log-bimbingan', [\App\Http\Controllers\Api\LogBimbinganController::class, 'index']);
    Route::post('log-bimbingan', [\App\Http\Controllers\Api\LogBimbinganController::class, 'store']);       
    Route::get('pembimbing', [\App\Http\Controllers\Api\LogBimbinganController::class, 'pembimbing']);
    Route::get('/pembimbing', [LogBimbinganController::class, 'pembimbing']);
    Route::get('/log-bimbingan/{dosen_nip}', [LogBimbinganController::class, 'logsByDosen']);
    //biar bisa edit log bimbingan
    Route::put('/log-bimbingan/{id}', [LogBimbinganController::class, 'update']);
    Route::patch('/log-bimbingan/{id}', [LogBimbinganController::class, 'update']);
    Route::delete('/log-bimbingan/{id}', [LogBimbinganController::class, 'destroy']);

    Route::get('log-bimbingan', [\App\Http\Controllers\Api\LogBimbinganController::class, 'index']);
    Route::post('log-bimbingan', [\App\Http\Controllers\Api\LogBimbinganController::class, 'store']);        //ini untuk daftar pembimbing ya (urutan), jangan dihapus
    Route::get('pembimbing', [\App\Http\Controllers\Api\LogBimbinganController::class, 'pembimbing']);

    Route::get('/pembimbing', [LogBimbinganController::class, 'pembimbing']);
    Route::get('/log-bimbingan/{dosen_nip}', [LogBimbinganController::class, 'logsByDosen']);
    
    //biar bisa edit 
    Route::put('/log-bimbingan/{id}', [LogBimbinganController::class, 'update']);
    Route::patch('/log-bimbingan/{id}', [LogBimbinganController::class, 'update']);
});


