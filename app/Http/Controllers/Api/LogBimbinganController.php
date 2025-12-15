<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\TugasAkhir;
use App\Models\Bimbingan;
use App\Models\LogBimbingan;
use Illuminate\Support\Facades\Storage;

class LogBimbinganController extends Controller
{
    // GET /api/log-bimbingan
    // optional query param: ?urutan=1
    public function index(Request $request)
    {
        $user = Auth::user();

        // 1. cari mahasiswa
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json(['message' => 'Data mahasiswa tidak ditemukan'], 404);
        }

        // 2. cari TA aktif mahasiswa
        $ta = TugasAkhir::whereHas('anggota', function ($q) use ($mahasiswa) {
            $q->where('mhs_nim', $mahasiswa->mhs_nim);
        })->latest()->first();

        if (!$ta) {
            return response()->json(['message' => 'Belum ada Tugas Akhir'], 404);
        }

        // 3. Siapkan query bimbingan (kita bisa filter berdasarkan urutan jika ada)
        $urutan = $request->query('urutan'); // null or '1', '2', etc.

        $bimbinganQuery = Bimbingan::where('tugas_akhir_id', $ta->id);
        if ($urutan) {
            $bimbinganQuery->where('urutan', intval($urutan));
        }
        // tetap butuh ordering untuk ambil id (jika multiple)
        $bimbinganIds = $bimbinganQuery->orderBy('urutan', 'asc')->pluck('id');

        if ($bimbinganIds->isEmpty()) {
            return response()->json([]); // tidak ada log
        }

        // 4. Ambil log bimbingan terkait (urutan tanggal desc)
        $logs = LogBimbingan::whereIn('bimbingan_id', $bimbinganIds)
            ->with(['bimbingan.dosen'])
            ->orderBy('tanggal', 'desc')
            ->get();

        // 5. Format output (tambahkan dosen_nip dan urutan)
        $formattedLogs = $logs->map(function ($log) {
            return [
                'id'         => $log->id,
                'judul'      => $log->judul,
                'deskripsi'  => $log->deskripsi,
                'tanggal'    => $log->tanggal,
                'status'     => $log->status,
                'pembimbing' => $log->bimbingan->dosen->dosen_nama ?? 'Tidak diketahui',
                'dosen_nip'  => $log->bimbingan->dosen_nip ?? null,
                'urutan'     => $log->bimbingan->urutan ?? null,
                'file_url'   => $log->file_path ? asset('storage/' . $log->file_path) : null,
            ];
        });

        return response()->json($formattedLogs);
    }

    // GET /api/pembimbing
    // mengembalikan daftar pembimbing TA mahasiswa yang login, berurut by urutan
    public function pembimbing(Request $request)
    {
        $user = Auth::user();

        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json(['message' => 'Data mahasiswa tidak ditemukan'], 404);
        }

        $ta = TugasAkhir::whereHas('anggota', function ($q) use ($mahasiswa) {
            $q->where('mhs_nim', $mahasiswa->mhs_nim);
        })->latest()->first();

        if (!$ta) {
            return response()->json([]);
        }

        $bimbingans = Bimbingan::where('tugas_akhir_id', $ta->id)
            ->with('dosen')
            ->orderBy('urutan', 'asc')
            ->get();

        $result = $bimbingans->map(function ($b) {
            return [
                'urutan'      => $b->urutan,
                'dosen_nip'   => $b->dosen_nip,
                'dosen_nama'  => $b->dosen->dosen_nama ?? null,
                'bimbingan_id'=> $b->id,
            ];
        });

        return response()->json($result);
    }

    // GET /api/log-bimbingan/{dosen_nip} (optional: tetap tersedia)
    public function logsByDosen(Request $request, $dosenNip)
    {
        $user = Auth::user();

        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json(['message' => 'Data mahasiswa tidak ditemukan'], 404);
        }

        $ta = TugasAkhir::whereHas('anggota', function ($q) use ($mahasiswa) {
            $q->where('mhs_nim', $mahasiswa->mhs_nim);
        })->latest()->first();

        if (!$ta) {
            return response()->json([], 404);
        }

        $bimbinganIds = Bimbingan::where('tugas_akhir_id', $ta->id)
            ->where('dosen_nip', $dosenNip)
            ->pluck('id');

        if ($bimbinganIds->isEmpty()) {
            return response()->json([]);
        }

        $logs = LogBimbingan::whereIn('bimbingan_id', $bimbinganIds)
            ->with(['bimbingan.dosen'])
            ->orderBy('tanggal', 'desc')
            ->get();

        $formattedLogs = $logs->map(function ($log) {
            return [
                'id'         => $log->id,
                'judul'      => $log->judul,
                'deskripsi'  => $log->deskripsi,
                'tanggal'    => $log->tanggal,
                'status'     => $log->status,
                'pembimbing' => $log->bimbingan->dosen->dosen_nama ?? 'Tidak diketahui',
                'dosen_nip'  => $log->bimbingan->dosen_nip ?? null,
                'urutan'     => $log->bimbingan->urutan ?? null,
                'file_url'   => $log->file_path ? asset('storage/' . $log->file_path) : null,
            ];
        });

        return response()->json($formattedLogs);
    }

    // POST /api/log-bimbingan
    // menerima pembimbing_urutan (diutamakan) atau pembimbing (nama) sebagai fallback
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg',
            'pembimbing_urutan' => 'nullable|integer|min:1',
            'pembimbing' => 'nullable|string',
        ]);

        $user = Auth::user();

        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak valid'], 403);
        }

        $ta = TugasAkhir::whereHas('anggota', function ($q) use ($mahasiswa) {
            $q->where('mhs_nim', $mahasiswa->mhs_nim);
        })->latest()->first();

        if (!$ta) {
            return response()->json(['message' => 'Anda belum memiliki Tugas Akhir'], 403);
        }

        $bimbingan = null;
        if ($request->filled('pembimbing_urutan')) {
            $bimbingan = Bimbingan::where('tugas_akhir_id', $ta->id)
                ->where('urutan', $request->pembimbing_urutan)
                ->first();
        }

        if (!$bimbingan && $request->filled('pembimbing')) {
            $bimbingan = Bimbingan::where('tugas_akhir_id', $ta->id)
                ->whereHas('dosen', function ($q) use ($request) {
                    $q->where('dosen_nama', $request->pembimbing);
                })
                ->first();
        }

        if (!$bimbingan) {
            return response()->json(['message' => 'Dosen ini bukan pembimbing Anda atau urutan tidak valid'], 403);
        }

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . $mahasiswa->mhs_nim . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bimbingan_logs', $fileName, 'public');
        }

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

        // PUT /api/log-bimbingan/{id}
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg',
        ]);

        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak valid'], 403);
        }

        $log = LogBimbingan::find($id);
        if (!$log) {
            return response()->json(['message' => 'Log tidak ditemukan'], 404);
        }

        // update file jika ada
        if ($request->hasFile('file_path')) {
            // hapus file lama jika ada
            if ($log->file_path && Storage::disk('public')->exists($log->file_path)) {
                Storage::disk('public')->delete($log->file_path);
            }

            $file = $request->file('file_path');
            $fileName = time() . '_' . $mahasiswa->mhs_nim . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bimbingan_logs', $fileName, 'public');
            $log->file_path = $filePath;
        }

        // update field lainnya
        $log->judul = $request->judul;
        $log->deskripsi = $request->deskripsi;
        $log->tanggal = $request->tanggal;
        $log->save();

        return response()->json([
            'message' => 'Log berhasil diperbarui',
            'data' => $log
        ]);
    }

<<<<<<< Updated upstream
=======
    public function destroy($id)
    {
        $log = LogBimbingan::find($id);

        if (!$log) {
            return response()->json([
                'message' => 'Log bimbingan tidak ditemukan'
            ], 404);
        }

        $log->delete();

        return response()->json([
            'message' => 'Log bimbingan berhasil dihapus'
        ], 200);
    }
>>>>>>> Stashed changes
}
