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
use App\Models\Config; // Tambahkan import ini untuk mengakses konfigurasi

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

        if (!$ta) return response()->json(['message' => 'Belum ada Tugas Akhir'], 404);

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
            'status'      => 0, // Status awal masih menunggu approval
        ]);

        return response()->json([
            'message' => 'Log bimbingan berhasil ditambahkan',
            'data'    => $log
        ], 201);
    }

    // GET /api/log-bimbingan/status
    public function getStatus(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if (!$mahasiswa) return response()->json(['message' => 'Mahasiswa tidak valid'], 403);

        $ta = TugasAkhir::whereHas('anggota', function ($q) use ($mahasiswa) {
            $q->where('mhs_nim', $mahasiswa->mhs_nim);
        })->latest()->first();

        if (!$ta) return response()->json(['message' => 'Anda belum memiliki Tugas Akhir'], 403);

        // Ambil nilai minimal bimbingan dari konfigurasi
        $minBimbingan = (int) Config::getValue('min_bimbingan', 2);

        // Hitung jumlah log bimbingan yang disetujui untuk mahasiswa ini
        $jumlahLogDisetujui = LogBimbingan::whereHas('bimbingan', function ($query) use ($ta) {
                $query->where('tugas_akhir_id', $ta->id);
            })
            ->where('mhs_nim', $mahasiswa->mhs_nim)
            ->whereIn('status', [1, 2]) // Status 1 = disetujui, 2 = disetujui
            ->count();

        // Hitung total jumlah bimbingan yang seharusnya (jumlah pembimbing * minimal bimbingan per pembimbing)
        $jumlahPembimbing = $ta->bimbingan()->count();
        $totalBimbinganHarusnya = $jumlahPembimbing * $minBimbingan;

        $sudahMemenuhi = $jumlahLogDisetujui >= $minBimbingan;

        // Debug logging
        \Log::info("getStatus called for mahasiswa: {$mahasiswa->mhs_nim}");
        \Log::info("TA ID: {$ta->id}, Jumlah log disetujui: {$jumlahLogDisetujui}, Jumlah pembimbing: {$jumlahPembimbing}, Min bimbingan: {$minBimbingan}");

        $response = [
            'jumlah_disetujui' => $jumlahLogDisetujui,
            'total_yang_dibutuhkan' => $totalBimbinganHarusnya, // Ini buat nampilin di UI kayak 3/8
            'minimal_dibutuhkan_per_pembimbing' => $minBimbingan,
            'jumlah_pembimbing' => $jumlahPembimbing,
            'sudah_memenuhi_syarat' => $sudahMemenuhi,
            'sisa_kebutuhan' => max(0, $totalBimbinganHarusnya - $jumlahLogDisetujui) // Sisa total yang dibutuhkan
        ];

        \Log::info("getStatus response: " . json_encode($response));

        return response()->json($response);
    }

    // GET /api/configs/min-bimbingan
    public function getConfigMinBimbingan()
    {
        $minBimbingan = Config::getValue('min_bimbingan', 2);

        \Log::info("getConfigMinBimbingan called, returning: " . $minBimbingan);

        return response()->json([
            'setting_key' => 'min_bimbingan',
            'setting_value' => (int)$minBimbingan
        ]);
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

    // PATCH /api/log-bimbingan/{id}/approve
    public function approve(Request $request, $id)
    {
        $log = LogBimbingan::find($id);
        if (!$log) return response()->json(['message' => 'Log bimbingan tidak ditemukan'], 404);

        // Update status log menjadi disetujui (1)
        $log->status = 1;
        $log->save();

        // Ambil tugas akhir terkait
        $tugasAkhir = $log->bimbingan->tugasAkhir;

        // Cek apakah semua anggota sudah selesai bimbingan sesuai konfigurasi
        if ($tugasAkhir->semuaAnggotaSelesaiBimbingan()) {
            // Update status tugas akhir ke 'Bimbingan' (1) jika sebelumnya 'Diajukan' (0)
            // atau ke 'Sidang' (2) jika sebelumnya 'Bimbingan' (1)
            if ($tugasAkhir->status === '0' || $tugasAkhir->status === 'Diajukan') {
                $tugasAkhir->update(['status' => '1']); // Ubah ke status 'Bimbingan'
            } elseif ($tugasAkhir->status === '1' || $tugasAkhir->status === 'Bimbingan') {
                $tugasAkhir->update(['status' => '2']); // Ubah ke status 'Sidang'
            }
        }

        return response()->json([
            'message' => 'Log bimbingan berhasil disetujui',
            'data'    => $log
        ]);
    }

    // PATCH /api/log-bimbingan/{id}/reject
    public function reject(Request $request, $id)
    {
        $log = LogBimbingan::find($id);
        if (!$log) return response()->json(['message' => 'Log bimbingan tidak ditemukan'], 404);

        // Update status log menjadi ditolak (0)
        $log->status = 0;
        $log->save();

        return response()->json([
            'message' => 'Log bimbingan berhasil ditolak',
            'data'    => $log
        ]);
    }

    // DEBUG: GET /api/debug-status
    public function debugStatus(Request $request)
    {
        $user = Auth::user();

        // Cek user
        \Log::info("Debug Status - User: " . json_encode($user ? $user->toArray() : null));

        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        \Log::info("Debug Status - Mahasiswa: " . json_encode($mahasiswa ? $mahasiswa->toArray() : null));

        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak valid'], 403);
        }

        $ta = TugasAkhir::whereHas('anggota', function ($q) use ($mahasiswa) {
            $q->where('mhs_nim', $mahasiswa->mhs_nim);
        })->latest()->first();

        \Log::info("Debug Status - TA: " . json_encode($ta ? $ta->toArray() : null));

        if (!$ta) {
            return response()->json(['message' => 'Anda belum memiliki Tugas Akhir'], 403);
        }

        // Ambil nilai minimal bimbingan dari konfigurasi
        $minBimbingan = (int) Config::getValue('min_bimbingan', 2);
        \Log::info("Debug Status - Min Bimbingan: " . $minBimbingan);

        // Hitung jumlah log bimbingan yang disetujui untuk mahasiswa ini
        $jumlahLogDisetujui = LogBimbingan::whereHas('bimbingan', function ($query) use ($ta) {
                $query->where('tugas_akhir_id', $ta->id);
            })
            ->where('mhs_nim', $mahasiswa->mhs_nim)
            ->whereIn('status', [1, 2])
            ->count();

        \Log::info("Debug Status - Jumlah Log Disetujui: " . $jumlahLogDisetujui);

        // Hitung total jumlah bimbingan yang seharusnya
        $jumlahPembimbing = $ta->bimbingan()->count();
        \Log::info("Debug Status - Jumlah Pembimbing: " . $jumlahPembimbing);

        $totalBimbinganHarusnya = $jumlahPembimbing * $minBimbingan;

        $sudahMemenuhi = $jumlahLogDisetujui >= $minBimbingan;

        return response()->json([
            'user' => $user->toArray(),
            'mahasiswa' => $mahasiswa->toArray(),
            'ta' => $ta->toArray(),
            'jumlah_log_disetujui' => $jumlahLogDisetujui,
            'jumlah_pembimbing' => $jumlahPembimbing,
            'min_bimbingan' => $minBimbingan,
            'total_yang_dibutuhkan' => $totalBimbinganHarusnya,
            'sudah_memenuhi_syarat' => $sudahMemenuhi
        ]);
    }
}
