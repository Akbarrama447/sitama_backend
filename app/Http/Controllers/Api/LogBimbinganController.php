<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ModelApi\Mahasiswa;
use App\Models\ModelApi\TugasAkhir;
use App\Models\ModelApi\Bimbingan;
use App\Models\ModelApi\LogBimbingan;

class LogBimbinganController extends Controller
{
    // GET /api/log-bimbingan
    public function index(Request $request)
    {
        $user = Auth::user();

        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) return response()->json(['message' => 'Data mahasiswa tidak ditemukan'], 404);

        $ta = TugasAkhir::whereHas('anggota', function ($q) use ($mahasiswa) {
            $q->where('mhs_nim', $mahasiswa->mhs_nim);
        })->latest()->first();

        if (!$ta) return response()->json(['message' => 'Belum ada Tugas Akhir'], 404);

        $urutan = $request->query('urutan');
        $bimbinganQuery = Bimbingan::where('tugas_akhir_id', $ta->id);
        if ($urutan) $bimbinganQuery->where('urutan', intval($urutan));

        $bimbinganIds = $bimbinganQuery->orderBy('urutan', 'asc')->pluck('id');
        if ($bimbinganIds->isEmpty()) return response()->json([]);

        $logs = LogBimbingan::whereIn('bimbingan_id', $bimbinganIds)
            ->where('mhs_nim', $mahasiswa->mhs_nim)  // Ditambahin
            ->with(['bimbingan.dosen'])
            ->orderBy('tanggal', 'desc')
            ->get();

        $formattedLogs = $logs->map(function ($log) {
            return [
                'id'         => $log->id,
                'judul'      => $log->judul,
                'deskripsi'  => $log->deskripsi,
                'catatan'    => $log->catatan,
                'tanggal'    => $log->tanggal,
                'status'     => $log->status,
                'mhs_nim'    => $log->mhs_nim,
                'pembimbing' => $log->bimbingan->dosen->dosen_nama ?? 'Tidak diketahui',
                'dosen_nip'  => $log->bimbingan->dosen_nip ?? null,
                'urutan'     => $log->bimbingan->urutan ?? null,
                'file_url'   => $log->file_path ? asset('storage/' . $log->file_path) : null,
            ];
        });

        return response()->json($formattedLogs);
    }

    // GET /api/pembimbing
    public function pembimbing(Request $request)
    {
        $user = Auth::user();

        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) return response()->json(['message' => 'Data mahasiswa tidak ditemukan'], 404);

        $ta = TugasAkhir::whereHas('anggota', function ($q) use ($mahasiswa) {
            $q->where('mhs_nim', $mahasiswa->mhs_nim);
        })->latest()->first();

        if (!$ta) return response()->json([]);

        $bimbingans = Bimbingan::where('tugas_akhir_id', $ta->id)
            ->with('dosen')
            ->orderBy('urutan', 'asc')
            ->get();

        $result = $bimbingans->map(function ($b) {
            return [
                'urutan'       => $b->urutan,
                'dosen_nip'    => $b->dosen_nip,
                'dosen_nama'   => $b->dosen->dosen_nama ?? null,
                'bimbingan_id' => $b->id,
                'label'        => 'Pembimbing ' . $b->urutan . ' - ' . ($b->dosen->dosen_nama ?? 'N/A'),
            ];
        });

        return response()->json($result);
    }

    // GET /api/log-bimbingan/{dosen_nip}
    public function logsByDosen(Request $request, $dosenNip)
    {
        $user = Auth::user();

        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) return response()->json(['message' => 'Data mahasiswa tidak ditemukan'], 404);

        $ta = TugasAkhir::whereHas('anggota', function ($q) use ($mahasiswa) {
            $q->where('mhs_nim', $mahasiswa->mhs_nim);
        })->latest()->first();

        if (!$ta) return response()->json([], 404);

        $bimbinganIds = Bimbingan::where('tugas_akhir_id', $ta->id)
            ->where('dosen_nip', $dosenNip)
            ->pluck('id');

        if ($bimbinganIds->isEmpty()) return response()->json([]);

        $logs = LogBimbingan::whereIn('bimbingan_id', $bimbinganIds)
            ->where('mhs_nim', $mahasiswa->mhs_nim)  // Ditambahin
            ->with(['bimbingan.dosen'])
            ->orderBy('tanggal', 'desc')
            ->get();

        $formattedLogs = $logs->map(function ($log) {
            return [
                'id'         => $log->id,
                'judul'      => $log->judul,
                'deskripsi'  => $log->deskripsi,
                'catatan'    => $log->catatan,
                'tanggal'    => $log->tanggal,
                'status'     => $log->status,
                'mhs_nim'    => $log->mhs_nim,
                'pembimbing' => $log->bimbingan->dosen->dosen_nama ?? 'Tidak diketahui',
                'dosen_nip'  => $log->bimbingan->dosen_nip ?? null,
                'urutan'     => $log->bimbingan->urutan ?? null,
                'file_url'   => $log->file_path ? asset('storage/' . $log->file_path) : null,
            ];
        });

        return response()->json($formattedLogs);
    }

    // POST /api/log-bimbingan
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'catatan' => 'nullable|string',
            'tanggal' => 'required|date',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg',
            'pembimbing_urutan' => 'nullable|integer|min:1',
            'pembimbing' => 'nullable|string',
        ]);

        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) return response()->json(['message' => 'Mahasiswa tidak valid'], 403);

        $ta = TugasAkhir::whereHas('anggota', function ($q) use ($mahasiswa) {
            $q->where('mhs_nim', $mahasiswa->mhs_nim);
        })->latest()->first();

        if (!$ta) return response()->json(['message' => 'Anda belum memiliki Tugas Akhir'], 403);

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

        if (!$bimbingan) return response()->json(['message' => 'Dosen ini bukan pembimbing Anda atau urutan tidak valid'], 403);

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . $mahasiswa->mhs_nim . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bimbingan_logs', $fileName, 'public');

            // Copy file ke public/storage juga untuk kompatibilitas Windows
            if ($filePath) {
                $sourcePath = storage_path('app/public/' . $filePath);
                $destPath = public_path('storage/' . $filePath);

                // Buat direktori jika belum ada
                $destDir = dirname($destPath);
                if (!file_exists($destDir)) {
                    mkdir($destDir, 0755, true);
                }

                // Copy file
                copy($sourcePath, $destPath);
            }
        }

        $log = LogBimbingan::create([
            'bimbingan_id' => $bimbingan->id,
            'mhs_nim'     => $mahasiswa->mhs_nim,
            'judul'       => $request->judul,
            'deskripsi'   => $request->deskripsi,
            'catatan'     => $request->catatan,
            'tanggal'     => $request->tanggal,
            'file_path'   => $filePath,
            'status'      => 0,
        ]);

        // Perbarui status tugas akhir ke 'Bimbingan' (1) jika sebelumnya 'Diajukan' (0)
        $tugasAkhir = $log->bimbingan->tugasAkhir;
        if ($tugasAkhir->status === 'Diajukan' || $tugasAkhir->status === '0') {
            $tugasAkhir->update(['status' => '1']); // Ubah ke status 'Bimbingan'
        }

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
            'catatan' => 'nullable|string',
            'tanggal' => 'required|date',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg',
        ]);

        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) return response()->json(['message' => 'Mahasiswa tidak valid'], 403);

        $log = LogBimbingan::find($id);
        if (!$log) return response()->json(['message' => 'Log tidak ditemukan'], 404);

        if ($request->hasFile('file_path')) {
            if ($log->file_path && Storage::disk('public')->exists($log->file_path)) {
                Storage::disk('public')->delete($log->file_path);

                // Hapus juga dari public/storage
                $publicFilePath = public_path('storage/' . $log->file_path);
                if (file_exists($publicFilePath)) {
                    unlink($publicFilePath);
                }
            }
            $file = $request->file('file_path');
            $fileName = time() . '_' . $mahasiswa->mhs_nim . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('bimbingan_logs', $fileName, 'public');
            $log->file_path = $filePath;

            // Copy file ke public/storage juga untuk kompatibilitas Windows
            if ($filePath) {
                $sourcePath = storage_path('app/public/' . $filePath);
                $destPath = public_path('storage/' . $filePath);

                // Buat direktori jika belum ada
                $destDir = dirname($destPath);
                if (!file_exists($destDir)) {
                    mkdir($destDir, 0755, true);
                }

                // Copy file
                copy($sourcePath, $destPath);
            }
        }

        $log->judul     = $request->judul;
        $log->deskripsi = $request->deskripsi;
        $log->catatan   = $request->catatan;
        $log->tanggal   = $request->tanggal;
        $log->save();

        return response()->json([
            'message' => 'Log berhasil diperbarui',
            'data'    => $log
        ]);
    }

    // DELETE /api/log-bimbingan/{id}
    public function destroy($id)
    {
        $log = LogBimbingan::find($id);
        if (!$log) return response()->json(['message' => 'Log bimbingan tidak ditemukan'], 404);

        // Hapus file dari storage jika ada
        if ($log->file_path) {
            // Hapus dari storage/app/public
            if (Storage::disk('public')->exists($log->file_path)) {
                Storage::disk('public')->delete($log->file_path);
            }

            // Hapus juga dari public/storage
            $publicFilePath = public_path('storage/' . $log->file_path);
            if (file_exists($publicFilePath)) {
                unlink($publicFilePath);
            }
        }

        $log->delete();
        return response()->json(['message' => 'Log bimbingan berhasil dihapus'], 200);
    }
}
