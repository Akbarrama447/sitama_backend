<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\ModelApi\Mahasiswa;
use App\Models\ModelApi\TugasAkhir;
use App\Models\ModelApi\JadwalSidang;
use App\Models\ModelApi\SidangTugasAkhir;

class DaftarSidangController extends Controller
{
    /**
     * Ambil jadwal sidang yang tersedia.
     * Endpoint: GET /api/jadwal-sidang/tersedia
     */
    public function jadwalTersedia(): JsonResponse
    {
        try {
            // Ambil semua jadwal sidang yang kapasitasnya belum penuh
            // Asumsi: satu jadwal bisa diisi maksimal 10 mahasiswa
            // Kita cek dari tabel sidang_tugas_akhir berdasarkan jadwal_sidang_id
            $kapasitasMaksimal = 10; // Kapasitas maksimal per jadwal sidang

            $jadwalTersedia = JadwalSidang::with(['sesi', 'ruangan'])
                ->get()
                ->filter(function ($jadwal) use ($kapasitasMaksimal) {
                    // Hitung jumlah sidang yang udah terdaftar di jadwal ini
                    $jumlahPendaftar = $jadwal->sidangTugasAkhir()
                        ->whereHas('tugasAkhir', function ($query) {
                            $query->where('status', '!=', 'Selesai');
                        })
                        ->count();

                    // Kembalikan true jika kapasitas belum penuh
                    return $jumlahPendaftar < $kapasitasMaksimal;
                })
                ->values(); // Reset key setelah filter

            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal sidang tersedia berhasil diambil',
                'data' => $jadwalTersedia
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil jadwal sidang',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mahasiswa daftar sidang.
     * Endpoint: POST /api/daftar-sidang
     */
    public function daftarSidang(Request $request): JsonResponse
    {
        $user = $request->user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:500',
            'jadwal_sidang_id' => 'required|exists:jadwal_sidang,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Mulai transaksi database
            \DB::beginTransaction();

            // Cek apakah mahasiswa udah punya TA aktif
            $tugasAkhir = $mahasiswa->tugasAkhir()
                ->where('status', '!=', 'Selesai')
                ->first();

            // Jika belum punya TA, buat TA baru
            if (!$tugasAkhir) {
                $tugasAkhir = TugasAkhir::create([
                    'judul' => $request->judul,
                    'deskripsi' => '', // Bisa ditambahin nanti
                    'status' => 'Aktif',
                    'tahun_akademik' => date('Y') . '/' . (date('Y') + 1) // Format tahun ajaran
                ]);

                // Hubungkan mahasiswa ke TA ini
                $tugasAkhir->mahasiswa()->attach($mahasiswa->mhs_nim);
            } else {
                // Jika TA udah ada, cuman update judulnya
                $tugasAkhir->update(['judul' => $request->judul]);
            }

            // Cek apakah mahasiswa ini udah daftar sidang sebelumnya
            $cekDaftarSebelumnya = SidangTugasAkhir::where('tugas_akhir_id', $tugasAkhir->id)
                ->where('mhs_nim', $mahasiswa->mhs_nim) // Tambahkan kondisi ini
                ->first();

            if ($cekDaftarSebelumnya) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda sudah terdaftar dalam sidang sebelumnya'
                ], 400);
            }

            // Cek apakah syarat sidang udah lengkap
            if (!$tugasAkhir->syaratSidangLengkap()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Syarat sidang belum lengkap. Pastikan semua surat telah diverifikasi oleh admin.'
                ], 400);
            }

            // Cek apakah jadwal sidang yang dipilih masih tersedia
            $jadwalSidang = JadwalSidang::find($request->jadwal_sidang_id);
            if (!$jadwalSidang) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jadwal sidang tidak ditemukan'
                ], 404);
            }

            // Cek apakah jadwal sidang udah penuh (misal: maksimal 10 mahasiswa per jadwal)
            $jumlahPendaftar = SidangTugasAkhir::where('jadwal_sidang_id', $request->jadwal_sidang_id)
                ->whereHas('tugasAkhir', function ($query) {
                    $query->where('status', '!=', 'Selesai');
                })
                ->count();

            // Asumsikan kapasitas maksimal per jadwal adalah 10, harus konsisten dengan fungsi jadwalTersedia
            $kapasitasMaksimal = 10;
            if ($jumlahPendaftar >= $kapasitasMaksimal) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jadwal sidang ini sudah penuh'
                ], 400);
            }

            // Buat record di tabel sidang_tugas_akhir
            $sidang = SidangTugasAkhir::create([
                'tugas_akhir_id' => $tugasAkhir->id,
                'mhs_nim' => $mahasiswa->mhs_nim, // Tambahkan ini
                'jadwal_sidang_id' => $request->jadwal_sidang_id,
                'status' => 'Aktif'
            ]);

            // Commit transaksi
            \DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Pendaftaran sidang berhasil',
                'data' => [
                    'sidang_id' => $sidang->id,
                    'tugas_akhir_id' => $tugasAkhir->id,
                    'judul_tugas_akhir' => $tugasAkhir->judul,
                    'jadwal_sidang' => $jadwalSidang->load(['sesi', 'ruangan']),
                    'tanggal_daftar' => $sidang->created_at
                ]
            ], 201);
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            \DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mendaftar sidang',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cek status pendaftaran sidang mahasiswa.
     * Endpoint: GET /api/pendaftaran-sidang
     */
    public function cekStatusPendaftaran(Request $request): JsonResponse
    {
        $user = $request->user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        try {
            // Cari TA aktif milik mahasiswa
            $tugasAkhir = $mahasiswa->tugasAkhir()
                ->where('status', '!=', 'Selesai')
                ->first();

            if (!$tugasAkhir) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Mahasiswa belum memiliki tugas akhir aktif',
                    'data' => null
                ], 200);
            }

            // Cari pendaftaran sidang terkait TA ini DAN milik mahasiswa ini
            $pendaftaranSidang = SidangTugasAkhir::where('tugas_akhir_id', $tugasAkhir->id)
                ->where('mhs_nim', $mahasiswa->mhs_nim) // Tambahkan kondisi ini
                ->with(['jadwalSidang.sesi', 'jadwalSidang.ruangan', 'tugasAkhir'])
                ->first();

            $responseData = [
                'tugas_akhir' => [
                    'id' => $tugasAkhir->id,
                    'judul' => $tugasAkhir->judul,
                    'status' => $tugasAkhir->status,
                    'syarat_sidang_lengkap' => $tugasAkhir->syaratSidangLengkap()
                ]
            ];

            if ($pendaftaranSidang) {
                $responseData['pendaftaran_sidang'] = [
                    'id' => $pendaftaranSidang->id,
                    'status' => $pendaftaranSidang->status,
                    'jadwal_sidang' => $pendaftaranSidang->jadwalSidang,
                    'tanggal_daftar' => $pendaftaranSidang->created_at
                ];
            } else {
                $responseData['pendaftaran_sidang'] = null;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Status pendaftaran sidang berhasil diambil',
                'data' => $responseData
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil status pendaftaran',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}