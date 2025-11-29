<?php

namespace App\Http\Controllers;

use App\Models\DokumenSidang;
use App\Models\SyaratSidang;
use App\Models\TugasAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DokumenSidangController extends Controller
{
    /**
     * Menampilkan semua dokumen sidang milik user yang sedang login
     */
    public function index()
    {
        // Dapatkan user yang sedang login
        $user = Auth::user();
        
        // Hubungan: users -> mahasiswa (via user_id) -> tugas_akhir_anggota (via mhs_nim) -> tugas_akhir -> syarat_sidang -> dokumen_sidang
        $dokumenSidangIds = DokumenSidang::join('syarat_sidang', 'dokumen_sidang.syarat_sidang_id', '=', 'syarat_sidang.id')
            ->join('tugas_akhir_anggota', 'syarat_sidang.tugas_akhir_id', '=', 'tugas_akhir_anggota.tugas_akhir_id')
            ->join('mahasiswa', 'tugas_akhir_anggota.mhs_nim', '=', 'mahasiswa.mhs_nim')
            ->where('mahasiswa.user_id', $user->id)
            ->select('dokumen_sidang.id')
            ->pluck('id')
            ->toArray();

        $dokumenSidang = DokumenSidang::whereIn('id', $dokumenSidangIds)->get();

        return response()->json([
            'status' => 'success',
            'data' => $dokumenSidang
        ]);
    }

    /**
     * Menyimpan dokumen sidang baru
     */
    public function store(Request $request)
    {
        // Validasi user memiliki akses ke syarat_sidang_id yang akan diupdate
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'syarat_sidang_id' => 'required|integer|exists:syarat_sidang,id',
            'dokumen' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // Max 10MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek apakah syarat_sidang_id terkait dengan tugas_akhir milik user
        $syaratSidang = SyaratSidang::find($request->syarat_sidang_id);
        if (!$syaratSidang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Syarat sidang tidak ditemukan'
            ], 404);
        }

        // Cek apakah user memiliki akses ke tugas akhir ini
        // Berdasarkan model, kolom tugas_akhir_id di tabel syarat_sidang mengacu ke id di tabel tugas_akhir
        $cekAkses = DB::table('tugas_akhir_anggota')
            ->join('mahasiswa', 'tugas_akhir_anggota.mhs_nim', '=', 'mahasiswa.mhs_nim')
            ->where('tugas_akhir_anggota.tugas_akhir_id', $syaratSidang->tugas_akhir_id) // Menggunakan tugas_akhir_id sesuai model
            ->where('mahasiswa.user_id', $user->id)
            ->exists();

        if (!$cekAkses) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak. Anda tidak memiliki izin untuk mengakses syarat sidang ini.'
            ], 403);
        }

        $file = $request->file('dokumen');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->store('dokumen_sidang', 'public');

        $dokumenSidang = DokumenSidang::create([
            'syarat_sidang_id' => $request->syarat_sidang_id,
            'nama_dokumen' => $file->getClientOriginalName(),
            'path_dokumen' => $filePath,
            'tipe_dokumen' => $file->getClientOriginalExtension(),
        ]);

        // Kembalikan data tanpa eager loading untuk menghindari error
        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen sidang berhasil ditambahkan',
            'data' => $dokumenSidang
        ], 201);
    }

    /**
     * Menampilkan dokumen sidang tertentu milik user yang sedang login
     */
    public function show($id)
    {
        $user = Auth::user();
        
        $dokumenSidang = DokumenSidang::with('syaratSidang')
            ->join('syarat_sidang', 'dokumen_sidang.syarat_sidang_id', '=', 'syarat_sidang.id')
            ->join('tugas_akhir_anggota', 'syarat_sidang.tugas_akhir_id', '=', 'tugas_akhir_anggota.tugas_akhir_id')
            ->join('mahasiswa', 'tugas_akhir_anggota.mhs_nim', '=', 'mahasiswa.mhs_nim')
            ->where('dokumen_sidang.id', $id)
            ->where('mahasiswa.user_id', $user->id)
            ->select('dokumen_sidang.*')
            ->first();

        if (!$dokumenSidang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dokumen sidang tidak ditemukan atau tidak diizinkan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $dokumenSidang
        ]);
    }

    /**
     * Update dokumen sidang
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        $dokumenSidang = DokumenSidang::with('syaratSidang')
            ->join('syarat_sidang', 'dokumen_sidang.syarat_sidang_id', '=', 'syarat_sidang.id')
            ->join('tugas_akhir_anggota', 'syarat_sidang.tugas_akhir_id', '=', 'tugas_akhir_anggota.tugas_akhir_id')
            ->join('mahasiswa', 'tugas_akhir_anggota.mhs_nim', '=', 'mahasiswa.mhs_nim')
            ->where('dokumen_sidang.id', $id)
            ->where('mahasiswa.user_id', $user->id)
            ->select('dokumen_sidang.*', 'syarat_sidang.id as syarat_sidang_id')
            ->first();

        if (!$dokumenSidang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dokumen sidang tidak ditemukan atau tidak diizinkan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'syarat_sidang_id' => 'sometimes|required|integer|exists:syarat_sidang,id',
            'dokumen' => 'sometimes|required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update dokumen jika ada
        if ($request->hasFile('dokumen')) {
            $file = $request->file('dokumen');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->store('dokumen_sidang', 'public');

            // Hapus file lama jika ada
            if ($dokumenSidang->path_dokumen) {
                Storage::disk('public')->delete($dokumenSidang->path_dokumen);
            }

            $dokumenSidang->update([
                'syarat_sidang_id' => $request->syarat_sidang_id ?? $dokumenSidang->syarat_sidang_id,
                'nama_dokumen' => $file->getClientOriginalName(),
                'path_dokumen' => $filePath,
                'tipe_dokumen' => $file->getClientOriginalExtension(),
            ]);
        } else {
            $dokumenSidang->update([
                'syarat_sidang_id' => $request->syarat_sidang_id ?? $dokumenSidang->syarat_sidang_id,
            ]);
        }

        // Kembalikan data tanpa eager loading untuk menghindari error
        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen sidang berhasil diperbarui',
            'data' => $dokumenSidang
        ]);
    }

    /**
     * Hapus dokumen sidang
     */
    public function destroy($id)
    {
        $user = Auth::user();
        
        $dokumenSidang = DokumenSidang::join('syarat_sidang', 'dokumen_sidang.syarat_sidang_id', '=', 'syarat_sidang.id')
            ->join('tugas_akhir_anggota', 'syarat_sidang.tugas_akhir_id', '=', 'tugas_akhir_anggota.tugas_akhir_id')
            ->join('mahasiswa', 'tugas_akhir_anggota.mhs_nim', '=', 'mahasiswa.mhs_nim')
            ->where('dokumen_sidang.id', $id)
            ->where('mahasiswa.user_id', $user->id)
            ->select('dokumen_sidang.*')
            ->first();

        if (!$dokumenSidang) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dokumen sidang tidak ditemukan atau tidak diizinkan'
            ], 404);
        }

        // Hapus file dari storage
        if ($dokumenSidang->path_dokumen) {
            Storage::disk('public')->delete($dokumenSidang->path_dokumen);
        }

        $dokumenSidang->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Dokumen sidang berhasil dihapus'
        ]);
    }
}