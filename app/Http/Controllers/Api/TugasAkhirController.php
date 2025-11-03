<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\TugasAkhir; // <-- Import Model TA
use Illuminate\Support\Facades\DB; // <-- TAMBAHAN IMPORT UNTUK TRANSAKSI

class TugasAkhirController extends Controller
{
    /**
     * Mengambil data tugas akhir milik mahasiswa yang sedang login.
     * Endpoint: GET /api/tugas-akhir
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        // 1. Pastikan user adalah mahasiswa
        if ($user->role !== 'mahasiswa') {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        // 2. Ambil data mahasiswa-nya
        $mahasiswa = $user->mahasiswa;
        if (!$mahasiswa) {
            return response()->json(['message' => 'Profil mahasiswa tidak ditemukan.'], 404);
        }

        // 3. Ambil data TA yang aktif
        $tugasAkhir = $mahasiswa->tugasAkhir()
                                ->with(
                                    'bimbingan.dosen', // Ambil pembimbing
                                    'mahasiswa'        // Ambil anggota
                                )
                                ->where('status', '!=', 'Selesai')
                                ->first();

        // 4. Jika tidak punya TA aktif
        if (!$tugasAkhir) {
            return response()->json([
                'status' => 'success',
                'message' => 'Mahasiswa ini tidak memiliki data tugas akhir yang aktif.',
                'data' => null
            ], 200);
        }

        // 5. Format data balikan menggunakan helper
        $dataTA = $this->formatTugasAkhirResponse($tugasAkhir);

        return response()->json([
            'status' => 'success',
            'data' => $dataTA
        ]);
    }

    /**
     * FUNGSI BARU (YANG KAMU MINTA)
     * Membuat (mengajukan) data tugas akhir baru.
     * Endpoint: POST /api/tugas-akhir
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();
        $mahasiswa = $user->mahasiswa;

        // 1. Cek dulu, jangan sampai mahasiswa bisa bikin 2 TA
        $existingTA = $mahasiswa->tugasAkhir()
                                ->where('status', '!=', 'Selesai')
                                ->first();

        if ($existingTA) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah memiliki Tugas Akhir yang aktif.'
            ], 409); // 409 Conflict
        }

        // 2. Validasi input
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:500',
            'deskripsi' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid', 
                'errors' => $validator->errors()
            ], 422);
        }
        
        $dataTA = null;

        try {
            // 3. Gunakan Transaction (Biar aman)
            // Kita harus insert ke 2 tabel: 'tugas_akhir' dan 'tugas_akhir_anggota'
            DB::transaction(function () use ($request, $mahasiswa, &$dataTA) {
                
                // 4. Buat data TA baru
                $tugasAkhir = TugasAkhir::create([
                    'judul' => $request->input('judul'),
                    'deskripsi' => $request->input('deskripsi'),
                    'status' => 'Diajukan', // Status default saat pertama kali buat
                    'tahun_akademik' => '2024/2025' // TODO: Harusnya dinamis
                ]);

                // 5. Sambungkan TA baru ini ke mahasiswa yang login
                // (Insert ke tabel 'tugas_akhir_anggota')
                $tugasAkhir->mahasiswa()->attach($mahasiswa->mhs_nim);

                // 6. Siapkan data balikan (load relasi biar lengkap)
                $tugasAkhir->load('bimbingan.dosen', 'mahasiswa');
                $dataTA = $this->formatTugasAkhirResponse($tugasAkhir);
            });

            // 7. Kembalikan data TA yang baru dibuat
            return response()->json([
                'status' => 'success',
                'message' => 'Tugas Akhir berhasil diajukan.',
                'data' => $dataTA
            ], 201); // 201 Created

        } catch (\Exception $e) {
            // Kalau ada error di tengah-tengah transaksi
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyimpan data ke database.',
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Meng-update data tugas akhir milik mahasiswa yang sedang login.
     * Endpoint: PUT /api/tugas-akhir
     */
    public function update(Request $request): JsonResponse
    {
        $user = $request->user();
        $mahasiswa = $user->mahasiswa;

        // 1. Cari TA aktif milik mahasiswa tsb
        $tugasAkhir = $mahasiswa->tugasAkhir()
                                ->where('status', '!=', 'Selesai')
                                ->first();

        if (!$tugasAkhir) {
            return response()->json(['message' => 'Tugas Akhir aktif tidak ditemukan.'], 404);
        }
        
        // 2. Validasi input
        $validator = Validator::make($request->all(), [
            'judul' => 'sometimes|required|string|max:500',
            'deskripsi' => 'sometimes|required|string', // <-- PERBAIKAN TYPO 'deskiripsi'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid', 
                'errors' => $validator->errors()
            ], 422);
        }

        // 3. Update data TA (lebih efisien pakai 'update' krn $fillable sdh ada)
        $tugasAkhir->update($request->only(['judul', 'deskripsi']));

        // 4. PERBAIKAN BUG: Ambil data baru dari database
        $tugasAkhir->refresh(); 

        // 5. Load ulang relasi untuk data yang baru (penting)
        $tugasAkhir->load('bimbingan.dosen', 'mahasiswa');
        
        // 6. Format data balikan menggunakan helper (BIAR KONSISTEN)
        $dataTA = $this->formatTugasAkhirResponse($tugasAkhir);

        // 7. Kembalikan data yang sudah di-update
        return response()->json([
            'status' => 'success',
            'message' => 'Tugas Akhir berhasil di-update.', // <-- PERBAIKAN TYPO 'massage'
            'data' => $dataTA // <-- Data terformat
        ]);
    }

    /**
     * FUNGSI HELPER BARU
     * Untuk format balikan data TA biar konsisten
     */
    private function formatTugasAkhirResponse(TugasAkhir $tugasAkhir): array
    {
        // 1. Olah data pembimbing
        $pembimbing1 = null;
        $pembimbing2 = null;
        // Pastikan relasi 'bimbingan' sudah di-load
        if ($tugasAkhir->relationLoaded('bimbingan')) {
            foreach ($tugasAkhir->bimbingan as $bimbingan) {
                if ($bimbingan->urutan == 1) {
                    $pembimbing1 = $bimbingan->dosen->dosen_nama ?? '...';
                }
                if ($bimbingan->urutan == 2) {
                    $pembimbing2 = $bimbingan->dosen->dosen_nama ?? '...';
                }
            }
        }

        // 2. Olah data anggota kelompok
        $anggota = [];
        // Pastikan relasi 'mahasiswa' sudah di-load
        if ($tugasAkhir->relationLoaded('mahasiswa')) {
            foreach ($tugasAkhir->mahasiswa as $mhs) {
                $anggota[] = [
                    'nim' => $mhs->mhs_nim,
                    'nama' => $mhs->mhs_nama,
                ];
            }
        }

        // 3. Format data balikan
        return [
            'judul' => $tugasAkhir->judul,
            'deskripsi' => $tugasAkhir->deskripsi,
            'status' => $tugasAkhir->status,
            'pembimbing_1' => $pembimbing1,
            'pembimbing_2' => $pembimbing2,
            'anggota_kelompok' => $anggota,
        ];
    }
}

