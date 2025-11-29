<?php

namespace App\Http\Controllers;

use App\Models\SyaratSidang;
use App\Models\FileDokumenSidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FileDokumenSidangController extends Controller
{
    /**
     * Menampilkan semua file dokumen sidang
     */
    public function index()
    {
        $fileDokumenSidang = FileDokumenSidang::with('syaratSidang')->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $fileDokumenSidang
        ]);
    }

    /**
     * Menyimpan file dokumen sidang baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'syarat_sidang_id' => 'required|exists:syarat_sidang,syarat_sidang_id',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // Max 10MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->store('syarat_sidang_tambahan', 'public');

        $fileDokumenSidang = FileDokumenSidang::create([
            'syarat_sidang_id' => $request->syarat_sidang_id,
            'nama_file' => $file->getClientOriginalName(),
            'path_file' => $filePath,
            'tipe_file' => $file->getClientOriginalExtension(),
            'ukuran_file' => $file->getSize(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'File dokumen sidang berhasil ditambahkan',
            'data' => $fileDokumenSidang->load('syaratSidang')
        ], 201);
    }

    /**
     * Menampilkan file dokumen sidang tertentu
     */
    public function show($id)
    {
        $fileDokumenSidang = FileDokumenSidang::with('syaratSidang')->find($id);

        if (!$fileDokumenSidang) {
            return response()->json([
                'status' => 'error',
                'message' => 'File dokumen sidang tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $fileDokumenSidang
        ]);
    }

    /**
     * Update file dokumen sidang
     */
    public function update(Request $request, $id)
    {
        $fileDokumenSidang = FileDokumenSidang::find($id);

        if (!$fileDokumenSidang) {
            return response()->json([
                'status' => 'error',
                'message' => 'File dokumen sidang tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'syarat_sidang_id' => 'sometimes|required|exists:syarat_sidang,syarat_sidang_id',
            'file' => 'sometimes|required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update file jika ada
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($fileDokumenSidang->path_file) {
                Storage::disk('public')->delete($fileDokumenSidang->path_file);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->store('syarat_sidang_tambahan', 'public');

            $fileDokumenSidang->update([
                'syarat_sidang_id' => $request->syarat_sidang_id ?? $fileDokumenSidang->syarat_sidang_id,
                'nama_file' => $file->getClientOriginalName(),
                'path_file' => $filePath,
                'tipe_file' => $file->getClientOriginalExtension(),
                'ukuran_file' => $file->getSize(),
            ]);
        } else {
            $fileDokumenSidang->update([
                'syarat_sidang_id' => $request->syarat_sidang_id ?? $fileDokumenSidang->syarat_sidang_id,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'File dokumen sidang berhasil diperbarui',
            'data' => $fileDokumenSidang->load('syaratSidang')
        ]);
    }

    /**
     * Hapus file dokumen sidang
     */
    public function destroy($id)
    {
        $fileDokumenSidang = FileDokumenSidang::find($id);

        if (!$fileDokumenSidang) {
            return response()->json([
                'status' => 'error',
                'message' => 'File dokumen sidang tidak ditemukan'
            ], 404);
        }

        // Hapus file dari storage
        if ($fileDokumenSidang->path_file) {
            Storage::disk('public')->delete($fileDokumenSidang->path_file);
        }

        $fileDokumenSidang->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'File dokumen sidang berhasil dihapus'
        ]);
    }
}