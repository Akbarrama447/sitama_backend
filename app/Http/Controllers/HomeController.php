<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Bimbingan;
use App\Models\BimbinganLog;
use App\Models\SidangTugasAkhir;
use App\Models\NilaiDosenPembimbing;
use App\Models\NilaiDosenPenguji;
use App\Models\TugasAkhir; // Untuk menghitung arsip judul
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Tampilkan dashboard dengan statistik real-time.
     */
    public function index()
    {
        $dosen = Dosen::where('user_id', Auth::id())->first();
        $nip = $dosen ? $dosen->dosen_nip : null;

        $stats = [
            'mahasiswa_aktif' => 0,
            'log_bimbingan_baru' => 0,
            'tugas_sidang_total' => 0,
            'tugas_penilaian_pending' => 0,
            'arsip_judul' => 0,
        ];

        if ($nip) {
            // A. Mahasiswa Aktif (Jumlah mahasiswa yang dibimbing)
            // Kita perlu menghitung jumlah mahasiswa yang terlibat dalam tugas akhir yang dibimbing oleh dosen
            $stats['mahasiswa_aktif'] = DB::table('bimbingan')
                ->join('tugas_akhir_anggota', 'bimbingan.tugas_akhir_id', '=', 'tugas_akhir_anggota.tugas_akhir_id')
                ->where('bimbingan.dosen_nip', $nip)
                ->distinct('tugas_akhir_anggota.mhs_nim') // Hitung berdasarkan NIM mahasiswa
                ->count('tugas_akhir_anggota.mhs_nim');

            // B. Log Bimbingan Baru (Log pending yang ditujukan kepada NIP ini)
            // Asumsi relasi bimbingan sudah terdefinisi di BimbinganLog
            $stats['log_bimbingan_baru'] = BimbinganLog::whereHas('bimbingan', function ($query) use ($nip) {
                $query->where('dosen_nip', $nip);
            })
            ->where('status', 0) // Status 0 = Pending/Baru
            ->count();

            // C. Tugas Sidang Total (Sidang di mana dosen terlibat)
            $stats['tugas_sidang_total'] = SidangTugasAkhir::whereHas('tugasAkhir.bimbingan', function ($query) use ($nip) {
                $query->where('dosen_nip', $nip);
            })
            ->orWhereHas('dosenPengujis', function ($query) use ($nip) {
                $query->where('dosen_penguji.dosen_nip', $nip);
            })
            ->orWhere('sekretaris_nip', $nip)
            ->count();

            // D. Tugas Penilaian Pending
            $stats['tugas_penilaian_pending'] = $this->countPendingNilai($nip);
        }

        // E. Arsip Judul (Total semua judul TA)
        $stats['arsip_judul'] = TugasAkhir::count();

        return view('home', compact('stats'));
    }

    /**
     * Helper untuk menghitung jumlah sidang yang belum diisi nilainya
     */
    private function countPendingNilai($nip)
    {
        $pendingCount = 0;

        // 1. Sidang di mana dosen adalah Pembimbing
        $sidangAsPembimbing = SidangTugasAkhir::whereHas('tugasAkhir.bimbingan', function ($query) use ($nip) {
            $query->where('dosen_nip', $nip);
        })->pluck('id');

        if ($sidangAsPembimbing->isNotEmpty()) {
            $filledCount = NilaiDosenPembimbing::whereIn('sidang_id', $sidangAsPembimbing)
                ->where('dosen_nip', $nip)
                ->count();
            
            $pendingCount += $sidangAsPembimbing->count() - $filledCount;
        }

        // 2. Sidang di mana dosen adalah Penguji
        $sidangAsPenguji = SidangTugasAkhir::whereHas('dosenPengujis', function ($query) use ($nip) {
            $query->where('dosen_penguji.dosen_nip', $nip);
        })->pluck('id');

        if ($sidangAsPenguji->isNotEmpty()) {
            $filledCount = NilaiDosenPenguji::whereIn('sidang_id', $sidangAsPenguji)
                ->where('dosen_nip', $nip)
                ->count();
            
            $pendingCount += $sidangAsPenguji->count() - $filledCount;
        }

        return $pendingCount;
    }
}