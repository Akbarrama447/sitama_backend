<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BimbinganLog;
use App\Models\TugasAkhir;
use App\Models\Bimbingan; // Pastikan model Bimbingan ada
use App\Models\Dosen;

class BimbinganController extends Controller
{
    /**
     * Menampilkan DAFTAR MAHASISWA (Style SITAMA).
     */
    public function index()
    {
        // 1. Ambil Data Dosen Login
        $dosen = Dosen::where('user_id', auth()->id())->first();
        if (!$dosen) {
            return redirect()->back()->with('error', 'Data Dosen tidak ditemukan.');
        }

        // 2. Gunakan method dari model Bimbingan untuk query data
        $daftarMahasiswa = Bimbingan::getBimbinganForDosen($dosen->dosen_nip)->paginate(10);

        return view('bimbingan.index', ['bimbingan' => $daftarMahasiswa]);
    }

    /**
     * Menampilkan DETAIL HISTORY BIMBINGAN.
     */
    public function show($ta_id)
    {
        $dosen = Dosen::where('user_id', auth()->id())->first();
        if (!$dosen) abort(403, 'Unauthorized');

        $ta = TugasAkhir::with('mahasiswa')->findOrFail($ta_id);

        // Determine role using the bimbingan table to check if this dosen is pembimbing
        $bimbingan = DB::table('bimbingan')
            ->where('tugas_akhir_id', $ta_id)
            ->where('dosen_nip', $dosen->dosen_nip)
            ->first();

        if ($bimbingan) {
            $peran = "Pembimbing " . $bimbingan->urutan;
            $isPembimbing = true;
        } else {
            $peran = "Pembimbing";
            $isPembimbing = false;
        }

        // Cek peran via sidang (jika ada) - untuk penguji
        $sidang = DB::table('sidang_tugas_akhir')->where('tugas_akhir_id', $ta_id)->first();
        if ($sidang && !$isPembimbing) {
            $peranData = DB::table('dosen_penguji')
                ->where('sidang_id', $sidang->id)
                ->where('dosen_nip', $dosen->dosen_nip)
                ->first();

            if ($peranData) {
                $peran = $peranData->peran;
                $isPembimbing = str_contains(strtolower($peran), 'pembimbing');
            }
        }

        // Use the relationship to get bimbingan logs for this ta_id
        $list = BimbinganLog::join('bimbingan', 'bimbingan_log.bimbingan_id', '=', 'bimbingan.id')
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