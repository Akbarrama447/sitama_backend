<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller
{
    /**
     * Mengambil data profil mahasiswa yang sedang login.
     * Endpoint: GET /api/profil
     */
    public function show(Request $request)
    {
        // $request->user() akan otomatis mengambil user yang login via token
        $user = $request->user();

        // Cek jika dia mahasiswa dan ambil data detailnya
        if ($user->role == 'mahasiswa') {
            // Kita gunakan relasi 'mahasiswa' yang sudah kita buat di model User
            // Kita pakai 'with()' untuk "Eager Loading",
            // ini cara efisien untuk mengambil data prodi dan jurusan sekaligus
            $mahasiswaProfil = $user->mahasiswa()->with('prodi.jurusan')->first();

            if ($mahasiswaProfil) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        // PERBAIKAN 1: Ambil nama dari data profil mahasiswa
                        'nama' => $mahasiswaProfil->mhs_nama,
                        'email' => $user->email,
                        'nim' => $mahasiswaProfil->mhs_nim,
                        'tahun_masuk' => $mahasiswaProfil->tahun_masuk,
                        'prodi' => $mahasiswaProfil->prodi->nama_prodi,
                        'jurusan' => $mahasiswaProfil->prodi->jurusan->nama_jurusan,
                    ]
                ]);
            }
            // Jika data relasi mahasiswa-nya kosong
            return response()->json(['message' => 'Detail profil mahasiswa tidak ditemukan'], 404);
        }

        // PERBAIKAN 2: Jika role bukan mahasiswa, kembalikan 403
        return response()->json(['message' => 'Akses ditolak. Hanya untuk mahasiswa.'], 403);
    }

    /**
     * Memperbarui password mahasiswa yang sedang login.
     * Endpoint: POST /api/ganti-password
     */
    public function gantiPassword(Request $request)
    {
        $user = $request->user();

        // 1. Validasi input
        $validated = $request->validate([
            'password_lama' => 'required|string',
            'password_baru' => ['required', 'string', 'confirmed', Password::min(8)],
            // 'password_baru_confirmation' harus ada di request
        ]);

        // 2. Cek apakah password lama sesuai
        if (!Hash::check($validated['password_lama'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password lama Anda tidak sesuai.'
            ], 401); // 401 Unauthorized
        }

        // 3. Update password baru
        $user->password = Hash::make($validated['password_baru']);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil diperbarui.'
        ]);
    }
}

