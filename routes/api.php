<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfilController;
use App\Http\Controllers\Api\TugasAkhirController;
use App\Http\Controllers\Api\JadwalSidangController;
use App\Http\Controllers\Api\LogBimbinganController;
use App\Http\Controllers\Api\DaftarSidangController;
use App\Http\Controllers\Api\DokumenSidangController;
use App\Http\Controllers\Api\FileDokumenSidangController;

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

    // Jadwal Sidang (untuk Tab Home)
    Route::get('/jadwal-sidang', [JadwalSidangController::class, 'index']);

    // Dokumen Sidang (dokumen te/api/dokumen-syaratrpisah untuk syarat sidang)
    Route::apiResource('/dokumen-sidang', \App\Http\Controllers\Api\DokumenSidangController::class);
    Route::post('/dokumen-sidang/upload-otomatis', [DokumenSidangController::class, 'storeOtomatis']);
    // File Dokumen Sidang (file tambahan untuk syarat sidang)
    Route::apiResource('/file-dokumen-sidang', \App\Http\Controllers\Api\FileDokumenSidangController::class);

    // Dokumen Syarat Sidang (spesifik untuk syarat sidang sesuai struktur PM)
        
    Route::get('/status-upload/{tugasAkhirId}', [\App\Http\Controllers\Api\SyaratSidangController::class, 'getStatusUpload']);
    Route::post('/upload-dokumen', [\App\Http\Controllers\Api\SyaratSidangController::class, 'uploadDokumen']);
    Route::get('/my-uploaded-documents', [\App\Http\Controllers\Api\SyaratSidangController::class, 'getMyUploadedDocuments']);
    Route::get('/uploaded-documents/{tugasAkhirId}', [\App\Http\Controllers\Api\SyaratSidangController::class, 'getUploadedDocuments']);
    Route::delete('/hapus-dokumen/{id}', [\App\Http\Controllers\Api\SyaratSidangController::class, 'deleteDokumen']);

    Route::get('/log-bimbingan/advisors', [LogBimbinganController::class, 'getAdvisors']); // Ambil daftar pembimbing
    Route::get('/log-bimbingan', [LogBimbinganController::class, 'index']); // Lihat histori
    Route::post('/log-bimbingan', [LogBimbinganController::class, 'store']); // Tambah log baru

    // Daftar Sidang
    Route::get('/jadwal-sidang/tersedia', [DaftarSidangController::class, 'jadwalTersedia']);
    Route::post('/daftar-sidang', [DaftarSidangController::class, 'daftarSidang']);
    Route::get('/pendaftaran-sidang', [DaftarSidangController::class, 'cekStatusPendaftaran']);

});


