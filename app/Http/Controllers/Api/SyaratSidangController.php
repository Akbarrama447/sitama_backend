<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModelApi\DokumenSidang;
use App\Models\ModelApi\SyaratSidang;
use App\Models\ModelApi\TugasAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SyaratSidangController extends Controller
{
    /**
     * Get all dokumen syarat
     */
    public function getDokumenSyarat()
    {
        $dokumenSyarat = DokumenSidang::select('dokumen_id', 'dokumen_syarat', 'keterangan', 'tipe_dokumen')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar dokumen syarat berhasil diambil',
            'data' => $dokumenSyarat
        ]);
    }

    /**
     * Get upload status for a specific tugas akhir
     */
    public function getStatusUpload($tugasAkhirId, Request $request)
    {
        $user = $request->user(); // Ambil user yang sedang login

        // Ambil data mahasiswa terkait user
        $mahasiswa = DB::table('mahasiswa')->where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        // Dapatkan semua jenis dokumen syarat
        $dokumenSyarat = DokumenSidang::select('dokumen_id', 'dokumen_syarat', 'keterangan', 'tipe_dokumen')
            ->get();

        // Dapatkan dokumen yang sudah diupload untuk tugas akhir ini OLEH USER YANG SEDANG LOGIN
        $uploadedDokumen = SyaratSidang::where('tugas_akhir_id', $tugasAkhirId)
            ->where('mhs_nim', $mahasiswa->mhs_nim) // Filter hanya dokumen yang diupload oleh user ini
            ->join('dokumen_sidang', 'syarat_sidang.dokumen_id', '=', 'dokumen_sidang.dokumen_id')
            ->select(
                'syarat_sidang.id',
                'syarat_sidang.dokumen_id',
                'syarat_sidang.dokumen_file_original',
                'syarat_sidang.dokumen_file',
                'syarat_sidang.verified',
                'syarat_sidang.tanggal_upload',
                'dokumen_sidang.dokumen_syarat'
            )
            ->get();

        // Gabungkan data
        $result = $dokumenSyarat->map(function ($dokumen) use ($uploadedDokumen) {
            $uploaded = $uploadedDokumen->firstWhere('dokumen_id', $dokumen->dokumen_id);

            return [
                'dokumen' => $dokumen,
                'uploaded' => $uploaded ? [
                    'id' => $uploaded->id,
                    'dokumen_file_original' => $uploaded->dokumen_file_original,
                    'dokumen_file' => $uploaded->dokumen_file,
                    'verified' => $uploaded->verified,
                    'tanggal_upload' => $uploaded->tanggal_upload
                ] : null
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Status upload berhasil diambil',
            'data' => $result
        ]);
    }

    /**
     * Upload dokumen sidang
     */
    public function uploadDokumen(Request $request)
    {
        $user = $request->user(); // Ambil user yang sedang login

        // Ambil data mahasiswa terkait user
        $mahasiswa = DB::table('mahasiswa')->where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        // Validasi input
        $rules = [
            'dokumen_id' => 'required|integer',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240' // max 10MB
        ];

        // Tambahkan validasi untuk tugas_akhir_id kalo dikirim
        if ($request->has('tugas_akhir_id')) {
            $rules['tugas_akhir_id'] = 'required|integer';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek apakah dokumen_id valid secara manual
        $dokumen = DokumenSidang::find($request->dokumen_id);
        if (!$dokumen) {
            return response()->json([
                'success' => false,
                'message' => 'Jenis dokumen tidak ditemukan'
            ], 404);
        }

        // Cek apakah tugas_akhir_id valid secara manual
        // Jika tidak disediakan, coba auto detect tugas_akhir_id aktif
        $tugasAkhirId = $request->tugas_akhir_id;
        if (!$tugasAkhirId) {
            // Cek apakah user punya tugas akhir aktif
            $tugasAkhirId = DB::table('mahasiswa')
                ->join('tugas_akhir_anggota', 'mahasiswa.mhs_nim', '=', 'tugas_akhir_anggota.mhs_nim')
                ->join('tugas_akhir', 'tugas_akhir_anggota.tugas_akhir_id', '=', 'tugas_akhir.id')
                ->where('mahasiswa.user_id', $user->id)
                ->where('tugas_akhir.status', '!=', 'Selesai')  // Hanya tugas akhir yang aktif
                ->select('tugas_akhir.id')
                ->first();

            if (!$tugasAkhirId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki tugas akhir aktif'
                ], 404);
            }

            $tugasAkhirId = $tugasAkhirId->id;
        } else {
            // Jika tugas_akhir_id disediakan, cek apakah valid
            $tugasAkhir = TugasAkhir::find($tugasAkhirId);
            if (!$tugasAkhir) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tugas akhir tidak ditemukan'
                ], 404);
            }
        }

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();

        // Buat nama file unik untuk mencegah konflik
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('dokumen_sidang', $fileName, 'public');

        // Cek apakah file sudah pernah diupload untuk dokumen_id, tugas_akhir_id dan mhs_nim yang sama
        $existingUpload = SyaratSidang::where('tugas_akhir_id', $tugasAkhirId)
            ->where('dokumen_id', $request->dokumen_id)
            ->where('mhs_nim', $mahasiswa->mhs_nim) // Tambahkan filter berdasarkan mahasiswa yang upload
            ->first();

        if ($existingUpload) {
            // Hapus file lama jika ada
            Storage::disk('public')->delete($existingUpload->dokumen_file);
            // Update record yang sudah ada
            $existingUpload->update([
                'dokumen_file_original' => $originalName,
                'dokumen_file' => $filePath,
                'verified' => 0, // reset status verifikasi
                'tanggal_upload' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diupdate',
                'data' => $existingUpload->fresh()
            ]);
        } else {
            // Buat record baru
            $syaratSidang = SyaratSidang::create([
                'tugas_akhir_id' => $tugasAkhirId,
                'dokumen_id' => $request->dokumen_id,
                'mhs_nim' => $mahasiswa->mhs_nim, // Simpan informasi siapa yang upload
                'dokumen_file_original' => $originalName,
                'dokumen_file' => $filePath,
                'verified' => 0, // belum diverifikasi
                'tanggal_upload' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dokumen berhasil diupload',
                'data' => $syaratSidang
            ]);
        }
    }

    /**
     * Get uploaded documents for the authenticated user's active tugas akhir
     */
    public function getMyUploadedDocuments(Request $request)
    {
        $user = $request->user(); // Mendapatkan user yang sedang login

        // Ambil data mahasiswa terkait user
        $mahasiswa = DB::table('mahasiswa')->where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        // Ambil tugas akhir aktif milik user
        // Asumsi: relasi dari user -> mahasiswa -> tugas akhir anggota -> tugas akhir
        $tugasAkhirId = DB::table('mahasiswa')
            ->join('tugas_akhir_anggota', 'mahasiswa.mhs_nim', '=', 'tugas_akhir_anggota.mhs_nim')
            ->join('tugas_akhir', 'tugas_akhir_anggota.tugas_akhir_id', '=', 'tugas_akhir.id')
            ->where('mahasiswa.user_id', $user->id)
            ->where('tugas_akhir.status', '!=', 'Selesai')  // Hanya tugas akhir yang aktif
            ->select('tugas_akhir.id')
            ->first();

        if (!$tugasAkhirId) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki tugas akhir aktif'
            ], 404);
        }

        // Ambil semua dokumen yang sudah diupload untuk tugas akhir ini OLEH USER INI
        $uploadedDokumen = SyaratSidang::where('tugas_akhir_id', $tugasAkhirId->id)
            ->where('mhs_nim', $mahasiswa->mhs_nim) // Filter hanya dokumen yang diupload oleh user ini
            ->join('dokumen_sidang', 'syarat_sidang.dokumen_id', '=', 'dokumen_sidang.dokumen_id')
            ->select(
                'syarat_sidang.id',
                'syarat_sidang.dokumen_id',
                'syarat_sidang.dokumen_file_original',
                'syarat_sidang.dokumen_file',
                'syarat_sidang.verified',
                'syarat_sidang.tanggal_upload',
                'dokumen_sidang.dokumen_syarat',
                'dokumen_sidang.keterangan'
            )
            ->orderBy('dokumen_sidang.dokumen_syarat')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar dokumen yang diupload berhasil diambil',
            'data' => $uploadedDokumen
        ]);
    }

    /**
     * Get uploaded documents for a specific tugas akhir
     * (Akses hanya untuk user yang punya akses ke tugas akhir tersebut)
     */
    public function getUploadedDocuments($tugasAkhirId, Request $request)
    {
        $user = $request->user();

        // Ambil data mahasiswa terkait user
        $mahasiswa = DB::table('mahasiswa')->where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        // Cek apakah user punya akses ke tugas akhir ini
        // Asumsi: gunakan relasi dari user -> mahasiswa -> tugas akhir anggota -> tugas akhir
        $cekAkses = DB::table('mahasiswa')
            ->join('tugas_akhir_anggota', 'mahasiswa.mhs_nim', '=', 'tugas_akhir_anggota.mhs_nim')
            ->where('mahasiswa.user_id', $user->id)
            ->where('tugas_akhir_anggota.tugas_akhir_id', $tugasAkhirId)
            ->exists();

        if (!$cekAkses) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Anda tidak memiliki izin untuk mengakses tugas akhir ini.'
            ], 403);
        }

        // Ambil semua dokumen yang sudah diupload untuk tugas akhir ini OLEH USER INI
        $uploadedDokumen = SyaratSidang::where('tugas_akhir_id', $tugasAkhirId)
            ->where('mhs_nim', $mahasiswa->mhs_nim) // Filter hanya dokumen yang diupload oleh user ini
            ->join('dokumen_sidang', 'syarat_sidang.dokumen_id', '=', 'dokumen_sidang.dokumen_id')
            ->select(
                'syarat_sidang.id',
                'syarat_sidang.dokumen_id',
                'syarat_sidang.dokumen_file_original',
                'syarat_sidang.dokumen_file',
                'syarat_sidang.verified',
                'syarat_sidang.tanggal_upload',
                'dokumen_sidang.dokumen_syarat',
                'dokumen_sidang.keterangan'
            )
            ->orderBy('dokumen_sidang.dokumen_syarat')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar dokumen yang diupload berhasil diambil',
            'data' => $uploadedDokumen
        ]);
    }

    /**
     * Delete uploaded dokumen
     */
    public function deleteDokumen($id, Request $request)
    {
        $user = $request->user();

        // Ambil data mahasiswa terkait user
        $mahasiswa = DB::table('mahasiswa')->where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data mahasiswa tidak ditemukan'
            ], 404);
        }

        $syaratSidang = SyaratSidang::where('id', $id)
            ->where('mhs_nim', $mahasiswa->mhs_nim) // Pastikan hanya user yang bersangkutan yang bisa hapus
            ->first();

        if (!$syaratSidang) {
            return response()->json([
                'success' => false,
                'message' => 'Dokumen tidak ditemukan atau Anda tidak memiliki izin untuk menghapus dokumen ini'
            ], 404);
        }

        // Hapus file dari storage
        if ($syaratSidang->dokumen_file) {
            Storage::disk('public')->delete($syaratSidang->dokumen_file);
        }

        $syaratSidang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil dihapus'
        ]);
    }
}