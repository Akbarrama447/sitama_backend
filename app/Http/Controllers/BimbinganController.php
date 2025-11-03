<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BimbinganController extends Controller
{
    public function index()
    {
        $dosen = auth()->user()->dosen ?? null;
        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan.');
        }

        $nipDosen = $dosen->dosen_nip;

        // Join antar tabel
        $bimbinganList = DB::table('bimbingan')
            ->join('tugas_akhir', 'bimbingan.tugas_akhir_id', '=', 'tugas_akhir.id')
            ->join('mahasiswa', 'mahasiswa.user_id', '=', 'tugas_akhir.id') // sementara
            ->where('bimbingan.dosen_nip', $nipDosen)
            ->select(
                'bimbingan.*',
                'tugas_akhir.judul as tugas_judul',
                'mahasiswa.mhs_nama'
            )
            ->get();

        // Hitung total mahasiswa & TA
        $totalMahasiswa = $bimbinganList->count();
        $tugasAkhirDibimbing = $bimbinganList->pluck('tugas_akhir_id')->unique()->count();

        return view('dosen.bimbingan', compact(
            'bimbinganList',
            'totalMahasiswa',
            'tugasAkhirDibimbing'
        ));
    }

    public function approve($id)
    {
        DB::table('bimbingan')
            ->where('id', $id)
            ->update(['approved' => true]);

        return redirect()->back()->with('success', 'Bimbingan berhasil di-approve!');
    }
}