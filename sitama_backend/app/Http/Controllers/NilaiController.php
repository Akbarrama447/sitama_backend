<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\TugasAkhir;
use App\Models\SidangTugasAkhir; // Pastikan model ini sesuai dengan nama tabel (sidang_tugas_akhir)
use App\Models\DosenPenguji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class NilaiController extends Controller
{
    /**
     * Show the nilai page based on the user's role in the TA
     */
    public function show($ta_id)
    {
        $dosen = Dosen::where('user_id', auth()->id())->first();
        if (!$dosen) {
            abort(403, 'Akses ditolak: Data dosen tidak ditemukan.');
        }

        // Ambil TA dan Sidang
        $ta = TugasAkhir::with(['mahasiswa'])->findOrFail($ta_id);
        
        // Ambil data sidang dari tabel yang benar 'sidang_tugas_akhir'
        // Asumsi relasi di model TugasAkhir sudah benar atau kita ambil manual
        $sidang = DB::table('sidang_tugas_akhir')->where('tugas_akhir_id', $ta_id)->first();

        if (!$sidang) {
            abort(404, 'Sidang belum dibuat untuk Tugas Akhir ini.');
        }

        // Determine the role of the user in this TA
        $role = $this->determineRole($dosen->dosen_nip, $ta, $sidang);

        switch ($role) {
            case 'pembimbing':
                return $this->showPembimbingNilai($ta, $sidang, $dosen);
            case 'penguji':
                return $this->showPengujiNilai($ta, $sidang, $dosen);
            case 'sekretaris':
                return $this->showSekretarisNilai($ta, $sidang);
            default:
                abort(403, 'Anda tidak memiliki akses untuk memberikan nilai di Tugas Akhir ini. Peran Anda tidak ditemukan.');
        }
    }

    /**
     * Determine the role of the dosen in the TA
     */
    private function determineRole($nip, $ta, $sidang)
    {
        // 1. Cek apakah Dosen Pembimbing (via tabel bimbingan)
        $isPembimbing = DB::table('bimbingan')
            ->where('tugas_akhir_id', $ta->id)
            ->where('dosen_nip', $nip)
            ->exists();

        if ($isPembimbing) {
            return 'pembimbing';
        }

        // 2. Cek apakah Dosen Penguji (via tabel dosen_penguji)
        if ($sidang) {
            $isPenguji = DB::table('dosen_penguji')
                ->where('sidang_id', $sidang->id)
                ->where('dosen_nip', $nip)
                ->exists();

            if ($isPenguji) {
                return 'penguji';
            }
        }

        // 3. Cek Sekretaris (jika ada kolom sekretaris di tabel sidang)
        // if ($sidang && isset($sidang->sekretaris_nip) && $sidang->sekretaris_nip === $nip) {
        //     return 'sekretaris';
        // }

        return 'none';
    }

    /**
     * Show nilai page for pembimbing
     */
    private function showPembimbingNilai($ta, $sidang, $dosen)
    {
        // Ambil nilai dari tabel 'unsur_nilai_pembimbing'
        $nilai = DB::table('unsur_nilai_pembimbing')
            ->where('sidang_id', $sidang->id)
            ->where('dosen_nip', $dosen->dosen_nip)
            ->first();

        return view('nilai.pembimbing', [
            'ta' => $ta,
            'sidang' => $sidang,
            'nilai' => $nilai,
            'dosen' => $dosen
        ]);
    }

    /**
     * Show nilai page for penguji
     */
    private function showPengujiNilai($ta, $sidang, $dosen)
    {
        // Ambil data peran penguji (Penguji 1, 2, atau 3)
        $dosenPenguji = DB::table('dosen_penguji')
            ->where('sidang_id', $sidang->id)
            ->where('dosen_nip', $dosen->dosen_nip)
            ->first();

        // Ambil nilai dari tabel 'unsur_nilai_penguji'
        $nilai = DB::table('unsur_nilai_penguji')
            ->where('sidang_id', $sidang->id)
            ->where('dosen_nip', $dosen->dosen_nip)
            ->first();

        return view('nilai.penguji', [
            'ta' => $ta,
            'sidang' => $sidang,
            'dosenPenguji' => $dosenPenguji,
            'nilai' => $nilai,
            'dosen' => $dosen
        ]);
    }

    /**
     * Show nilai page for sekretaris (summary view)
     */
    private function showSekretarisNilai($ta, $sidang)
    {
        $nilaiPembimbing = DB::table('unsur_nilai_pembimbing')
            ->where('sidang_id', $sidang->id)
            ->get();

        $nilaiPenguji = DB::table('unsur_nilai_penguji')
            ->where('sidang_id', $sidang->id)
            ->get();

        return view('nilai.sekretaris', [
            'ta' => $ta,
            'sidang' => $sidang,
            'nilaiPembimbing' => $nilaiPembimbing,
            'nilaiPenguji' => $nilaiPenguji
        ]);
    }

    /**
     * Store pembimbing nilai
     * Unsur: Kedisiplinan, Kreativitas, Penguasaan Materi, Kelengkapan
     */
    public function storePembimbing(Request $request, $ta_id, $sidang_id)
    {
        $dosen = Dosen::where('user_id', auth()->id())->first();
        if (!$dosen) {
            abort(403, 'Akses ditolak: Data dosen tidak ditemukan.');
        }

        // Validasi input sesuai kolom tabel unsur_nilai_pembimbing
        $request->validate([
            'nilai_kedisiplinan'      => 'required|numeric|min:0|max:100',
            'nilai_kreativitas'       => 'required|numeric|min:0|max:100',
            'nilai_penguasaan_materi' => 'required|numeric|min:0|max:100',
            'nilai_kelengkapan'       => 'required|numeric|min:0|max:100',
            'catatan'                 => 'nullable|string'
        ]);

        // Cek apakah sudah ada nilai sebelumnya
        $existingRecord = DB::table('unsur_nilai_pembimbing')
            ->where('sidang_id', $sidang_id)
            ->where('dosen_nip', $dosen->dosen_nip)
            ->first();

        $data = [
            'nilai_kedisiplinan'      => $request->nilai_kedisiplinan,
            'nilai_kreativitas'       => $request->nilai_kreativitas,
            'nilai_penguasaan_materi' => $request->nilai_penguasaan_materi,
            'nilai_kelengkapan'       => $request->nilai_kelengkapan,
            'catatan'                 => $request->catatan,
            'updated_at'              => now(),
        ];

        if ($existingRecord) {
            // Update
            DB::table('unsur_nilai_pembimbing')
                ->where('id', $existingRecord->id)
                ->update($data);
        } else {
            // Insert
            $data['sidang_id']  = $sidang_id;
            $data['dosen_nip']  = $dosen->dosen_nip;
            $data['created_at'] = now();
            
            DB::table('unsur_nilai_pembimbing')->insert($data);
        }

        return redirect()->back()->with('success', 'Nilai pembimbing berhasil disimpan.');
    }

    /**
     * Store penguji nilai
     * Unsur: Isi Naskah, Penguasaan Materi, Presentasi, Hasil Rancang Bangun
     */
    public function storePenguji(Request $request, $ta_id, $sidang_id)
    {
        $dosen = Dosen::where('user_id', auth()->id())->first();
        if (!$dosen) {
            abort(403, 'Akses ditolak: Data dosen tidak ditemukan.');
        }

        // Validasi input sesuai kolom tabel unsur_nilai_penguji
        $request->validate([
            'nilai_isi_naskah'           => 'required|numeric|min:0|max:100',
            'nilai_penguasaan_materi'    => 'required|numeric|min:0|max:100',
            'nilai_presentasi'           => 'required|numeric|min:0|max:100',
            'nilai_hasil_rancang_bangun' => 'required|numeric|min:0|max:100',
            'catatan'                    => 'nullable|string'
        ]);

        // Cek apakah sudah ada nilai sebelumnya
        $existingRecord = DB::table('unsur_nilai_penguji')
            ->where('sidang_id', $sidang_id)
            ->where('dosen_nip', $dosen->dosen_nip)
            ->first();

        $data = [
            'nilai_isi_naskah'           => $request->nilai_isi_naskah,
            'nilai_penguasaan_materi'    => $request->nilai_penguasaan_materi,
            'nilai_presentasi'           => $request->nilai_presentasi,
            'nilai_hasil_rancang_bangun' => $request->nilai_hasil_rancang_bangun,
            'catatan'                    => $request->catatan,
            'updated_at'                 => now(),
        ];

        if ($existingRecord) {
            // Update
            DB::table('unsur_nilai_penguji')
                ->where('id', $existingRecord->id)
                ->update($data);
        } else {
            // Insert
            $data['sidang_id']  = $sidang_id;
            $data['dosen_nip']  = $dosen->dosen_nip;
            $data['created_at'] = now();

            DB::table('unsur_nilai_penguji')->insert($data);
        }

        return redirect()->back()->with('success', 'Nilai penguji berhasil disimpan.');
    }
}