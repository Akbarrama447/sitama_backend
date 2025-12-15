<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BimbinganLog;
use App\Models\TugasAkhir;
use App\Models\Bimbingan;
use App\Models\Dosen;

class BimbinganController extends Controller
{
    /**
     * Menampilkan DAFTAR MAHASISWA (Style SITAMA) dengan FILTER.
     */
    public function index(Request $request)
    {
        // 1. Ambil Data Dosen Login
        $dosen = Dosen::where('user_id', auth()->id())->first();
        if (!$dosen) {
            return redirect()->back()->with('error', 'Data Dosen tidak ditemukan.');
        }

        // 2. QUERY DAFTAR MAHASISWA
        $query = DB::table('bimbingan')
            ->join('tugas_akhir', 'bimbingan.tugas_akhir_id', '=', 'tugas_akhir.id')
            ->join('tugas_akhir_anggota', 'tugas_akhir.id', '=', 'tugas_akhir_anggota.tugas_akhir_id')
            ->join('mahasiswa', 'tugas_akhir_anggota.mhs_nim', '=', 'mahasiswa.mhs_nim')
            ->where('bimbingan.dosen_nip', $dosen->dosen_nip)
            // Filter: Hanya tampilkan yang SUDAH ADA log bimbingannya
            ->whereExists(function ($q) {
                $q->select(DB::raw(1))
                  ->from('bimbingan_log')
                  ->whereColumn('bimbingan_log.bimbingan_id', 'bimbingan.id');
            });

        // --- LOGIKA FILTER TAHUN AKADEMIK ---
        if ($request->filled('tahun_akademik')) {
            $query->where('tugas_akhir.tahun_akademik', $request->tahun_akademik);
        }
        // ------------------------------------

        // Select Data
        $daftarMahasiswa = $query->select(
                'tugas_akhir.id as ta_id',
                'tugas_akhir.judul as judul_ta',
                'tugas_akhir.tahun_akademik',
                'mahasiswa.mhs_nama',
                'mahasiswa.mhs_nim',
                'bimbingan.id as bimbingan_id',
                'bimbingan.urutan',
                DB::raw('(SELECT id FROM bimbingan_log WHERE bimbingan_log.bimbingan_id = bimbingan.id ORDER BY tanggal DESC LIMIT 1) as id'),
                DB::raw('(SELECT tanggal FROM bimbingan_log WHERE bimbingan_log.bimbingan_id = bimbingan.id ORDER BY tanggal DESC LIMIT 1) as tanggal'),
                DB::raw('(SELECT catatan FROM bimbingan_log WHERE bimbingan_log.bimbingan_id = bimbingan.id ORDER BY tanggal DESC LIMIT 1) as catatan'),
                DB::raw('(SELECT status FROM bimbingan_log WHERE bimbingan_log.bimbingan_id = bimbingan.id ORDER BY tanggal DESC LIMIT 1) as status'),
                DB::raw('(SELECT COUNT(*) FROM bimbingan_log WHERE bimbingan_log.bimbingan_id = bimbingan.id AND bimbingan_log.status = 2) as jumlah_verified')
            )
            ->groupBy('tugas_akhir.id')
            ->orderBy('mahasiswa.mhs_nama', 'asc')
            ->paginate(10);

        // Penting: Append query string agar filter tidak hilang saat pindah halaman
        $daftarMahasiswa->appends($request->all());

        return view('bimbingan.index', ['bimbingan' => $daftarMahasiswa]);
    }

    public function show($ta_id)
    {
        $dosen = Dosen::where('user_id', auth()->id())->first();
        if (!$dosen) abort(403, 'Unauthorized');

        $ta = TugasAkhir::query()->from('tugas_akhir')->with('mahasiswa')->findOrFail($ta_id);
        
        $peran = "Pembimbing"; 
        $isPembimbing = true;  

        $sidang = DB::table('sidang_tugas_akhir')->where('tugas_akhir_id', $ta_id)->first();
        if ($sidang) {
            $peranData = DB::table('dosen_penguji')
                ->where('sidang_id', $sidang->id) 
                ->where('dosen_nip', $dosen->dosen_nip)
                ->first();
            if ($peranData) {
                $peran = $peranData->peran;
                $isPembimbing = str_contains(strtolower($peran), 'pembimbing');
            }
        }

        $list = BimbinganLog::query()
            ->join('bimbingan', 'bimbingan_log.bimbingan_id', '=', 'bimbingan.id')
            ->where('bimbingan.tugas_akhir_id', $ta_id)
            ->select('bimbingan_log.*')
            ->orderBy('bimbingan_log.tanggal', 'desc')
            ->get();

        return view('bimbingan.show', [
            'ta'   => $ta,
            'list' => $list,
            'peran' => $peran,
            'isPembimbing' => $isPembimbing
        ]);
    }

    public function verify(Request $request, $id)
    {
        $log = BimbinganLog::findOrFail($id);
        $log->status = 2; 
        $log->save();
        return redirect()->back()->with('success', 'Verified');
    }

    public function reject(Request $request, $id)
    {
        $log = BimbinganLog::findOrFail($id);
        $log->status = 1; 
        $log->save();
        return redirect()->back()->with('success', 'Rejected');
    }
}