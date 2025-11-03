<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Menangani permintaan login dari aplikasi Flutter.
     */
    public function login(Request $request)
    {
        // 1. Validasi input (email dan password)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Coba autentikasi user
        if (!Auth::attempt($request->only('email', 'password'))) {
            // 3. Jika gagal, kirim respon error
            return response()->json([
                'message' => 'Email atau password salah.'
            ], 401);
        }

        // 4. Jika berhasil, ambil data user
        $user = User::where('email', $request->email)->firstOrFail();

        // 5. PENGECEKAN PENTING: Pastikan hanya mahasiswa yang bisa login
        if ($user->role !== 'mahasiswa') {
            return response()->json([
                'message' => 'Akses ditolak. Akun Anda bukan akun mahasiswa.'
            ], 403); // 403 = Forbidden
        }

        // 6. Buat token API menggunakan Sanctum
        $token = $user->createToken('auth_token_flutter_app')->plainTextToken;

        // 7. Kirim respon sukses beserta token dan data user
        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }

    /**
     * Menangani permintaan logout dari aplikasi Flutter.
     */
    public function logout(Request $request)
    {
        // Hapus token yang sedang digunakan untuk autentikasi
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ], 200);
    }
}

