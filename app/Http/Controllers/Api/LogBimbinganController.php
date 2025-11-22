<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
use App\Models\Bimbingan;
use App\Models\LogBimbingan;

class LogBimbinganController extends Controller
{
    // GET: Ambil semua histori log mahasiswa yang login
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. Cari Mahasiswa
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json(['message' => 'Data mahasiswa tidak ditemukan'], 404);
        }

        // 2. Cari TA aktif mahasiswa
        $ta = TugasAkhir::whereHas('anggota', function ($q) use ($mahasiswa) {
            $q->where('mhs_nim', $mahasiswa->mhs_nim);
        })->latest()->first();

        if (!$ta) {
            return response()->json(['message' => 'Belum ada Tugas Akhir'], 404);
        }

        // 3. Ambil semua bimbingan TA
        $bimbinganIds = Bimbingan::where('tugas_akhir_id', $ta->id)->pluck('id');

        if ($bimbinganIds->isEmpty()) {
            return response()->json([]); // tidak ada log
        }

        // 4. Ambil semua log bimbingan
        $logs = LogBimbingan::whereIn('bimbingan_id', $bimbinganIds)
            ->with(['bimbingan.dosen'])
            ->orderBy('tanggal', 'desc')
            ->get();

        // 5. Format output sesuai Flutter
        $formattedLogs = $logs->map(function ($log) {
            return [
                'id'         => $log->id,
                'judul'      => $log->judul,
                'deskripsi'  => $log->deskripsi,
                'tanggal'    => $log->tanggal,
                'status'     => $log->status,
                'pembimbing' => $log->bimbingan->dosen->dosen_nama ?? 'Tidak diketahui',
                'file_url'   => $log->file_path ? asset('storage/' . $log->file_path) : null,
            ];
        });

        return response()->json($formattedLogs);
    }

    // POST: Tambah log baru
    public function store(Request $request)
    {
        $request->validate([
            'judul'      => 'required|string',
            'deskripsi'  => 'required|string',
            'pembimbing' => 'required|string',
            'tanggal'    => 'required|date',
            'file_path'  => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg',
        ]);

        $user = Auth::user();

        // 1. Cari mahasiswa
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak valid'], 403);
        }

        // 2. Cari TA mahasiswa
        $ta = TugasAkhir::whereHas('anggota', function ($q) use ($mahasiswa) {
            $q->where('mhs_nim', $mahasiswa->mhs_nim);
        })->latest()->first();

        if (!$ta) {
            return response()->json(['message' => 'Anda belum memiliki Tugas Akhir'], 403);
        }

        // 3. Cari bimbingan berdasarkan nama dosen
        $bimbingan = Bimbingan::where('tugas_akhir_id', $ta->id)
            ->whereHas('dosen', function ($q) use ($request) {
                $q->where('dosen_nama', $request->pembimbing);
            })
            ->first();

        if (!$bimbingan) {
            return response()->json(['message' => 'Dosen ini bukan pembimbing Anda'], 403);
        }

        // 4. Upload file (FIX)
        $filePath = null;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . $mahasiswa->mhs_nim . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bimbingan_logs', $fileName, 'public');
        }

        // 5. Simpan log baru
        $log = LogBimbingan::create([
            'bimbingan_id' => $bimbingan->id,
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'tanggal'      => $request->tanggal,
            'file_path'    => $filePath,
            'status'       => 0,
        ]);

        return response()->json([
            'message' => 'Log bimbingan berhasil ditambahkan',
            'data'    => $log
        ], 201);
    }
}
