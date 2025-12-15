<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ModelApi\Mahasiswa;
use App\Models\ModelApi\TugasAkhir;
use App\Models\ModelApi\Bimbingan;
use App\Models\ModelApi\LogBimbingan;

class LogBimbinganController extends Controller
{
    // GET: Ambil daftar pembimbing untuk mahasiswa yang login
    public function getAdvisors(Request $request)
    {
        $user = Auth::user();
        // 1. Cari Mahasiswa dari User ID
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) return response()->json(['message' => 'Data mahasiswa tidak ditemukan'], 404);

        // 2. Cari TA Mahasiswa (ambil yang terbaru/aktif)
        $ta = TugasAkhir::whereHas('anggota', function ($q) use ($mahasiswa) {
            $q->where('mhs_nim', $mahasiswa->mhs_nim);
        })->latest()->first();

        if (!$ta) return response()->json(['message' => 'Belum ada Tugas Akhir'], 404);

        // 3. Ambil semua bimbingan terkait TA ini
        $bimbingans = Bimbingan::where('tugas_akhir_id', $ta->id)
            ->with('dosen')
            ->orderBy('urutan')
            ->get();

        // 4. Format data biar enak dibaca frontend
        $formattedAdvisors = $bimbingans->map(function ($bimbingan) {
            return [
                'bimbingan_id' => $bimbingan->id,
                'dosen_nip' => $bimbingan->dosen_nip,
                'dosen_nama' => $bimbingan->dosen->dosen_nama ?? 'N/A',
                'urutan' => $bimbingan->urutan,
                'label' => 'Pembimbing ' . $bimbingan->urutan . ' - ' . ($bimbingan->dosen->dosen_nama ?? 'N/A'),
            ];
        });

        return response()->json($formattedAdvisors);
    }

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
        $bimbinganIds = Bimbingan::where('tugas_akhir_id', $ta->id)->pluck('id');

        // 4. Ambil log berdasarkan bimbingan_id tadi dan mhs_nim mahasiswa ini
        $logs = LogBimbingan::whereIn('bimbingan_id', $bimbinganIds)
            ->where('mhs_nim', $mahasiswa->mhs_nim)
            ->with(['bimbingan.dosen']) // Load data dosen biar tahu log ini sama siapa
            ->orderBy('tanggal', 'desc')
            ->get();

        // 5. Format data biar enak dibaca frontend
        $formattedLogs = $logs->map(function ($log) {
            return [
                'id' => $log->id,
                'tanggal' => $log->tanggal,
                'catatan' => $log->catatan,
                'judul' => $log->judul,
                'deskripsi' => $log->deskripsi,
                'status'  => $log->status, // 0: Pending, 1: Disetujui
                'dosen'   => $log->bimbingan->dosen->dosen_nama ?? 'N/A',
                'pembimbing_ke' => $log->bimbingan->urutan, // Pembimbing 1 atau 2
                'file_path' => $log->file_path ? asset('storage/' . $log->file_path) : null,
            ];
        });

        return response()->json($formattedLogs);
    }

    // POST: Tambah log baru
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'catatan' => 'string',
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
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
            'mhs_nim' => $mahasiswa->mhs_nim,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status' => 0, // Default: Belum diverifikasi dosen
            'file_path' => $filePath,
        ]);

        return response()->json([
            'message' => 'Log bimbingan berhasil disimpan',
            'data' => $log
        ], 201);
    }
}