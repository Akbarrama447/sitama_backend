<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Bimbingan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $dosen = Auth::user()->dosen;
        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        $nipDosen = $dosen->nip;

        // Ambil semua bimbingan milik dosen
        $bimbinganList = Bimbingan::where('dosen_nip', $nipDosen)->get();

        // Hitung total mahasiswa unik (berdasarkan tugas akhir)
        $totalMahasiswa = $bimbinganList
            ->pluck('tugas_akhir_id')
            ->unique()
            ->count();

        // Jumlah TA yang dibimbing
        $tugasAkhirDibimbing = $totalMahasiswa;

        // Join ke jadwal_sidang untuk ambil tanggal sidang
        $jadwalSidang = DB::table('sidang_tugas_akhir')
            ->join('jadwal_sidang', 'sidang_tugas_akhir.jadwal_sidang_id', '=', 'jadwal_sidang.id')
            ->whereIn('sidang_tugas_akhir.tugas_akhir_id', $bimbinganList->pluck('tugas_akhir_id'))
            ->orderByDesc('jadwal_sidang.tanggal')
            ->value('jadwal_sidang.tanggal'); // 🟢 ambil tanggal terbaru

        return view('dashboards.dashboard', [
            'tugasAkhirDibimbing' => $tugasAkhirDibimbing,
            'totalMahasiswa' => $totalMahasiswa,
            'jadwalSidang' => $jadwalSidang ?? 'Belum dijadwalkan',
        ]);
    }
}
