<?php

namespace App\Http\Controllers;

use App\Models\BimbinganLog;
use App\Models\Dosen;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BimbinganController extends Controller
{
    public function index()
    {
        // 1. Cek Dosen
        $dosen = Dosen::where('user_id', auth()->id())->first();
        if (!$dosen) abort(404);

        // 2. QUERY JALUR BARU (5 TABEL)
        $bimbingan = BimbinganLog::query()
            // A. Sambung ke Bimbingan (Filter Dosen)
            ->join('bimbingan', 'bimbingan_log.bimbingan_id', '=', 'bimbingan.id')
            
            // B. Sambung ke Tugas Akhir
            ->join('tugas_akhir', 'bimbingan.tugas_akhir_id', '=', 'tugas_akhir.id')
            
            // C. Sambung ke Anggota (JEMBATAN BARU!)
            // Pastikan nama tabelnya 'tugas_akhir_anggota' atau 'tugas_akhir_anggotas'
            ->join('tugas_akhir_anggota', 'tugas_akhir.id', '=', 'tugas_akhir_anggota.tugas_akhir_id')
            
            // D. Sambung ke Mahasiswa
            // Pastikan nama kolom nim di tabel anggota benar (misal: mhs_nim, nim, atau mahasiswa_nim)
            ->join('mahasiswa', 'tugas_akhir_anggota.mhs_nim', '=', 'mahasiswa.mhs_nim')
            
            // Filter Dosen
            ->where('bimbingan.dosen_nip', $dosen->dosen_nip)
            
            // Select Kolom
            ->select(
                'bimbingan_log.*',
                'tugas_akhir.judul as judul_ta',
                'tugas_akhir.id as ta_id',
                'mahasiswa.mhs_nama',  // Akhirnya dapet nama mhs!
                'bimbingan.dosen_nip'
            )
            // Biar kalau anggotanya 2 orang, log-nya ga muncul dobel (Grouping by Log ID)
            ->groupBy('bimbingan_log.id') 
            ->orderBy('bimbingan_log.created_at', 'desc')
            ->get();

        return view('bimbingan.index', compact('bimbingan'));
    }

    public function verify($id) {
        $b = BimbinganLog::findOrFail($id);
        $b->status = 2; // 2 = Verified
        $b->save();
        return back()->with('success', 'Verified!');
    }

    public function reject($id) {
        $b = BimbinganLog::findOrFail($id);
        $b->status = 1; // 1 = Rejected
        $b->save();
        return back()->with('error', 'Rejected!');
    }
}