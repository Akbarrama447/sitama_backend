<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\ModelApi\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    /**
     * Mengirim OTP reset password ke user.
     */
    public function forgotPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:user,email',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'message' => 'Email tidak ditemukan.'
                ], 404);
            }

            // Generate OTP 6 digit
            $otp = rand(100000, 999999);

            // Simpan OTP ke database (gunakan table password_reset_tokens)
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'email' => $request->email,
                    'token' => hash('sha256', $otp), // Hash OTP untuk keamanan
                    'created_at' => now(),
                ]
            );

            // Kirim OTP lewat email
            $user->notify(new \App\Notifications\OtpResetPasswordNotification($otp));

            return response()->json([
                'message' => 'OTP reset password telah dikirim ke email Anda.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mereset password user dengan OTP.
     */
    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'otp' => 'required|numeric|digits:6', // Validasi OTP 6 digit
                'email' => 'required|email|exists:user,email',
                'password' => 'required|min:8|confirmed',
            ]);

            // Cek apakah OTP valid
            $otpRecord = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->first();

            if (!$otpRecord || !hash_equals(hash('sha256', $request->otp), $otpRecord->token)) {
                return response()->json([
                    'message' => 'OTP reset password tidak valid.'
                ], 400);
            }

            // Cek apakah OTP masih berlaku (misalnya dalam 10 menit terakhir)
            $createdAt = Carbon::parse($otpRecord->created_at);
            $now = Carbon::now();

            if ($now->diffInMinutes($createdAt) > 10) { // OTP berlaku selama 10 menit
                // Hapus OTP yang kadaluarsa
                DB::table('password_reset_tokens')->where('email', $request->email)->delete();

                return response()->json([
                    'message' => 'OTP reset password telah kadaluarsa.'
                ], 400);
            }

            // Update password user
            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            // Hapus OTP setelah digunakan
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return response()->json([
                'message' => 'Password berhasil direset.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}