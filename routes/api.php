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
use App\Http\Controllers\Api\SyaratSidangController;
use App\Http\Controllers\Api\RevisiTugasAkhirController;
use App\Http\Controllers\TestApiController;

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

    // Tugas Akhir
    Route::post('/tugas-akhir', [TugasAkhirController::class, 'store']);
    Route::get('/tugas-akhir', [TugasAkhirController::class, 'show']);
    Route::put('/tugas-akhir', [TugasAkhirController::class, 'update']);

    // Jadwal Sidang
    Route::get('/jadwal-sidang', [JadwalSidangController::class, 'index']);
    Route::get('/jadwal-sidang/tersedia', [DaftarSidangController::class, 'jadwalTersedia']);

    // Dokumen Sidang
    Route::apiResource('/dokumen-sidang', DokumenSidangController::class);
    Route::post('/dokumen-sidang/upload-otomatis', [DokumenSidangController::class, 'storeOtomatis']);
    Route::apiResource('/file-dokumen-sidang', FileDokumenSidangController::class);

    // Dokumen Syarat Sidang
    Route::get('/status-upload/{tugasAkhirId}', [SyaratSidangController::class, 'getStatusUpload']);
    Route::post('/upload-dokumen', [SyaratSidangController::class, 'uploadDokumen']);
    Route::get('/my-uploaded-documents', [SyaratSidangController::class, 'getMyUploadedDocuments']);
    Route::get('/uploaded-documents/{tugasAkhirId}', [SyaratSidangController::class, 'getUploadedDocuments']);
    Route::delete('/hapus-dokumen/{id}', [SyaratSidangController::class, 'deleteDokumen']);

    //bimbingan
    Route::get('/log-bimbingan', [LogBimbinganController::class, 'index']); // Lihat histori
    Route::post('/log-bimbingan', [LogBimbinganController::class, 'store']); // Tambah log baru
    Route::get('/log-bimbingan/{dosen_nip}', [LogBimbinganController::class, 'logsByDosen']);
    Route::get('/pembimbing', [LogBimbinganController::class, 'pembimbing']); // Daftar pembimbing
    //biar bisa edit log bimbingan
    Route::put('/log-bimbingan/{id}', [LogBimbinganController::class, 'update']);
    Route::patch('/log-bimbingan/{id}', [LogBimbinganController::class, 'update']);
    Route::delete('/log-bimbingan/{id}', [LogBimbinganController::class, 'destroy']);
    // Approval dan rejection log bimbingan
    Route::patch('/log-bimbingan/{id}/approve', [LogBimbinganController::class, 'approve']);
    Route::patch('/log-bimbingan/{id}/reject', [LogBimbinganController::class, 'reject']);
    // Status log bimbingan
    Route::get('/log-bimbingan/status', [LogBimbinganController::class, 'getStatus']);
    // DEBUG: Route untuk debug status
    Route::get('/debug-status', [LogBimbinganController::class, 'debugStatus']);
    // Endpoint untuk mendapatkan nilai konfigurasi minimal bimbingan
    Route::get('/configs/min-bimbingan', [LogBimbinganController::class, 'getConfigMinBimbingan']);

    // Daftar Sidang
    Route::post('/daftar-sidang', [DaftarSidangController::class, 'daftarSidang']);
    Route::get('/pendaftaran-sidang', [DaftarSidangController::class, 'cekStatusPendaftaran']);

    // Revisi Tugas Akhir
    Route::apiResource('/revisi-tugas-akhir', RevisiTugasAkhirController::class);
    Route::get('/revisi-tugas-akhir-by-ta/{tugas_akhir_id}', [RevisiTugasAkhirController::class, 'getByTugasAkhir']);
    Route::post('/revisi-tugas-akhir-untuk-saya', [RevisiTugasAkhirController::class, 'storeForCurrentUser']);
    Route::get('/revisi-tugas-akhir-saya', [RevisiTugasAkhirController::class, 'getForCurrentUser']);
    Route::post('/upload-revisi-file', [RevisiTugasAkhirController::class, 'uploadFileRevisi']);
    Route::post('/upload-revisi-file/{revisi_id}', [RevisiTugasAkhirController::class, 'uploadFileRevisiById']);

});
