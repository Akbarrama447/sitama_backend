<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada
use App\Models\SyaratSidang;

class SyaratSidangController extends Controller
{
    /**
     * Meng-upload file syarat sidang baru.
     * Endpoint: POST /api/syarat-sidang
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();
        $mahasiswa = $user->mahasiswa;

        // 1. Cari TA aktif milik mahasiswa
        $tugasAkhir = $mahasiswa->tugasAkhir()
                                ->where('status', '!=', 'Selesai')
                                ->first();

        if (!$tugasAkhir) {
            return response()->json(['message' => 'Tugas Akhir aktif tidak ditemukan.'], 404);
        }

        // 2. Validasi input
        $validator = Validator::make($request->all(), [
            'nama_syarat' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx|max:5120', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        // 3. Simpan file
        $file = $request->file('file');
        $nim = $mahasiswa->mhs_nim;
        $path = $file->store("public/syarat_sidang/{$nim}"); // Ini ngasilin 'public/syarat_sidang/...'

        // 4. Buat record di database
        $syarat = SyaratSidang::create([
            'tugas_akhir_id' => $tugasAkhir->id,
            'nama_syarat' => $request->input('nama_syarat'),
            'file_path' => $path, // Simpan path 'public/...'
            'status' => 'Diajukan',
        ]);

        //
        // --- PERBAIKAN DI SINI ---
        //
        // 5. Format data balikan biar Flutter seneng
        $dataBalikan = [
            'id' => $syarat->id,
            'tugas_akhir_id' => $syarat->tugas_akhir_id,
            'nama_syarat' => $syarat->nama_syarat,
            'status' => $syarat->status,
            'file_url' => Storage::url($syarat->file_path), // <-- INI MAGIC-NYA
            'uploaded_at' => $syarat->created_at->toDateTimeString(),
        ];
        
        // 6. Kembalikan respon sukses
        return response()->json([
            'status' => 'success',
            'message' => 'File berhasil di-upload.',
            'data' => $dataBalikan // <-- Kirim data yang sudah diformat
        ], 201);
    }
}

