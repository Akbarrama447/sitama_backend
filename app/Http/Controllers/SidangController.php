<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\NilaiDosenPembimbing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SidangController extends Controller
{
    public function index()
    {
        $dosen = Dosen::where('user_id', auth()->id())->first();
        if (!$dosen) abort(404);

        // QUERY JOIN
        $sidang = DB::table('sidang_tugas_akhir')
            // 1. Join ke Tugas Akhir & Mahasiswa
            ->join('tugas_akhir', 'sidang_tugas_akhir.tugas_akhir_id', '=', 'tugas_akhir.id')
            ->join('tugas_akhir_anggota', 'tugas_akhir.id', '=', 'tugas_akhir_anggota.tugas_akhir_id')
            ->join('mahasiswa', 'tugas_akhir_anggota.mhs_nim', '=', 'mahasiswa.mhs_nim')
            
            // 2. Join ke Bimbingan (Filter bimbingan saya)
            ->join('bimbingan', 'tugas_akhir.id', '=', 'bimbingan.tugas_akhir_id')
            
            // 3. LEFT JOIN ke Nilai Dosen Pembimbing
            // PERBAIKAN: Sesuaikan nama kolom dengan database baru (sidang_id)
            ->leftJoin('nilai_dosen_pembimbing', function($join) use ($dosen) {
                $join->on('sidang_tugas_akhir.id', '=', 'nilai_dosen_pembimbing.sidang_id')
                     ->where('nilai_dosen_pembimbing.dosen_nip', '=', $dosen->dosen_nip);
            })

            // Filter Dosen yg login
            ->where('bimbingan.dosen_nip', $dosen->dosen_nip)
            
            // Pilih Kolom
            ->select(
                'sidang_tugas_akhir.id as sidang_id',
                'sidang_tugas_akhir.status as status_jadwal',
                'tugas_akhir.judul',
                'mahasiswa.mhs_nama',
                'mahasiswa.mhs_nim',
                
                // PERBAIKAN: Sesuaikan nama kolom nilai (nilai)
                'nilai_dosen_pembimbing.nilai',
                'nilai_dosen_pembimbing.id as nilai_id'
                
                // CATATAN: status_lulus dan catatan_revisi DIHAPUS dari select
                // karena tidak ada di tabel nilai_dosen_pembimbing kamu yang sekarang.
            )
            ->distinct()
            ->orderBy('sidang_tugas_akhir.created_at', 'desc')
            ->get();

        return view('sidang.index', compact('sidang'));
    }

    public function store(Request $request)
{
    $dosen = Dosen::where('user_id', auth()->id())->first();
    
    if (!$dosen) {
        return abort(404, 'Data Dosen tidak ditemukan');
    }

    NilaiDosenPembimbing::updateOrCreate(
        [
            'sidang_id' => $request->sidang_id,
            'dosen_nip' => $dosen->dosen_nip, // Pastikan pake dosen_nip
            'unsur_id'  => 1
        ],
        [
            // Kolom database 'nilai' diisi dari input 'nilai_angka'
            'nilai' => $request->nilai_angka 
        ]
    );

    return back()->with('success', 'Nilai berhasil disimpan!');
}
}