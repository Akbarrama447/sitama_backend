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
        // 1. Cari Mahasiswa dari User ID
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) return response()->json(['message' => 'Data mahasiswa tidak ditemukan'], 404);

        // 2. Cari TA Mahasiswa (ambil yang terbaru/aktif)
        // Asumsi: Mahasiswa cuma punya 1 TA yang aktif
        $ta = TugasAkhir::whereHas('anggota', function ($q) use ($mahasiswa) {
            $q->where('mhs_nim', $mahasiswa->mhs_nim);
        })->latest()->first();

        if (!$ta) return response()->json(['message' => 'Belum ada Tugas Akhir'], 404);

        // 3. Ambil semua ID bimbingan terkait TA ini
        // (Bisa jadi dia punya Pembimbing 1 dan Pembimbing 2)
        $bimbinganIds = Bimbingan::where('tugas_akhir_id', $ta->id)->pluck('id');

        // 4. Ambil log berdasarkan bimbingan_id tadi
        $logs = LogBimbingan::whereIn('bimbingan_id', $bimbinganIds)
            ->with(['bimbingan.dosen']) // Load data dosen biar tahu log ini sama siapa
            ->orderBy('tanggal', 'desc')
            ->get();

        // 5. Format data biar enak dibaca frontend
        $formattedLogs = $logs->map(function ($log) {
            return [
                'id' => $log->id,
                'tanggal' => $log->tanggal,
                'catatan' => $log->catatan,
                'status'  => $log->status, // 0: Pending, 1: Disetujui
                'dosen'   => $log->bimbingan->dosen->dosen_nama ?? 'N/A',
                'pembimbing_ke' => $log->bimbingan->urutan, // Pembimbing 1 atau 2
                'file_path' => $log->file_path ? asset('storage/' . $log->file_path) : null,
            ];
        });

        return response()->json($formattedLogs);
    }

    // POST: Tambah log ba  ru
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'catatan' => 'required|string',
            'dosen_nip' => 'required|string', // Frontend harus kirim NIP dosen yang dibimbing
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // File BAB, max 10MB
        ]);

        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) return response()->json(['message' => 'Mahasiswa tidak valid'], 403);

        // 1. Cari TA-nya dulu
        $ta = TugasAkhir::whereHas('anggota', function ($q) use ($mahasiswa) {
            $q->where('mhs_nim', $mahasiswa->mhs_nim);
        })->latest()->first();

        if (!$ta) return response()->json(['message' => 'Anda belum memiliki Tugas Akhir'], 403);

        // 2. Cari 'bimbingan_id' yang pas (TA ini + Dosen yang dipilih)
        $bimbingan = Bimbingan::where('tugas_akhir_id', $ta->id)
            ->where('dosen_nip', $request->dosen_nip)
            ->first();

        if (!$bimbingan) {
            return response()->json(['message' => 'Dosen ini bukan pembimbing Anda'], 403);
        }

        // 3. Handle file upload jika ada
        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $mahasiswa->mhs_nim . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bimbingan_logs', $fileName, 'public');
        }

        // 4. Simpan Log
        $log = LogBimbingan::create([
            'bimbingan_id' => $bimbingan->id,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
            'status' => 0, // Default: Belum diverifikasi dosen
            'file_path' => $filePath,
        ]);

        return response()->json([
            'message' => 'Log bimbingan berhasil disimpan',
            'data' => $log
        ], 201);
    }
}