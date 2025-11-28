<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\TugasAkhir;
use App\Models\SidangTugasAkhir;
use App\Models\DosenPenguji;
use App\Models\NilaiDosenPembimbing;
use App\Models\NilaiDosenPenguji;
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

        $ta = TugasAkhir::with(['mahasiswa', 'sidang'])->findOrFail($ta_id);
        $sidang = $ta->sidang;

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
                abort(403, 'Anda tidak memiliki akses untuk memberikan nilai di Tugas Akhir ini.');
        }
    }

    /**
     * Determine the role of the dosen in the TA
     */
    private function determineRole($nip, $ta, $sidang)
    {
        // Check if dosen is pembimbing 1 or 2 (using old method as fallback)
        if ($ta->pembimbing_1_nip === $nip || $ta->pembimbing_2_nip === $nip) {
            return 'pembimbing';
        }

        // Check if dosen is pembimbing using bimbingan table (primary method now)
        $bimbingan = DB::table('bimbingan')
            ->where('tugas_akhir_id', $ta->id)
            ->where('dosen_nip', $nip)
            ->first();

        if ($bimbingan) {
            return 'pembimbing';
        }

        // Check if dosen is a penguji
        if ($sidang) {
            // Check if the dosen_penguji table exists
            if (Schema::hasTable('dosen_penguji')) {
                $dosenPenguji = DosenPenguji::where('sidang_id', $sidang->id)
                    ->where('dosen_nip', $nip)
                    ->first();
                if ($dosenPenguji) {
                    return 'penguji';
                }
            } else {
                // Fallback: check if dosen is penguji from sidang_tugas_akhir table
                if ($sidang->penguji_1_nip === $nip || $sidang->penguji_2_nip === $nip || $sidang->penguji_3_nip === $nip) {
                    return 'penguji';
                }
            }
        }

        // Check if dosen is sekretaris
        if ($sidang && $sidang->sekretaris_nip === $nip) {
            return 'sekretaris';
        }

        return 'none'; // No role found
    }

    /**
     * Show nilai page for pembimbing
     */
    private function showPembimbingNilai($ta, $sidang, $dosen)
    {
        // Check both possible table names and use the one that exists
        $tableExists = Schema::hasTable('unsur_nilai_pembimbing') || Schema::hasTable('unsur_nilai_dosen_pembimbing');

        if ($tableExists) {
            $table = Schema::hasTable('unsur_nilai_pembimbing') ? 'unsur_nilai_pembimbing' : 'unsur_nilai_dosen_pembimbing';

            // Use DB query to check if nilai record exists for this dosen and sidang
            $nilai = DB::table($table)
                ->where('sidang_id', $sidang->id)
                ->where('dosen_nip', $dosen->dosen_nip)
                ->first();
        } else {
            // Create a dummy object if table doesn't exist
            $nilai = null;
        }

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
        // Logic for penguji nilai (soal TA)
        $dosenPenguji = null;
        if (Schema::hasTable('dosen_penguji')) {
            $dosenPenguji = DosenPenguji::where('sidang_id', $sidang->id)
                ->where('dosen_nip', $dosen->dosen_nip)
                ->first();
        }

        // Check if nilai_penguji table exists (using the new table we created)
        if (Schema::hasTable('unsur_nilai_penguji') || Schema::hasTable('unsur_nilai_dosen_penguji')) {
            $table = Schema::hasTable('unsur_nilai_penguji') ? 'unsur_nilai_penguji' : 'unsur_nilai_dosen_penguji';
            $nilai = DB::table($table)
                ->where('sidang_id', $sidang->id)
                ->where('dosen_nip', $dosen->dosen_nip)
                ->first();
        } else {
            // Check if old nilai_dosen_penguji table exists (for backward compatibility)
            if (Schema::hasTable('nilai_dosen_penguji')) {
                $nilai = DB::table('nilai_dosen_penguji')
                    ->where('sidang_id', $sidang->id)
                    ->where('dosen_nip', $dosen->dosen_nip)
                    ->first();
            } else {
                $nilai = null;
            }
        }

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
        // Check if tables exist before querying - support both table names for pembimbing
        if (Schema::hasTable('unsur_nilai_pembimbing') || Schema::hasTable('unsur_nilai_dosen_pembimbing')) {
            $table = Schema::hasTable('unsur_nilai_pembimbing') ? 'unsur_nilai_pembimbing' : 'unsur_nilai_dosen_pembimbing';
            $nilaiPembimbing = DB::table($table)
                ->where('sidang_id', $sidang->id)
                ->get();
        } else {
            $nilaiPembimbing = collect(); // Empty collection
        }

        // Support both new and old table names for penguji
        if (Schema::hasTable('unsur_nilai_penguji') || Schema::hasTable('unsur_nilai_dosen_penguji')) {
            $table = Schema::hasTable('unsur_nilai_penguji') ? 'unsur_nilai_penguji' : 'unsur_nilai_dosen_penguji';
            $nilaiPenguji = DB::table($table)
                ->where('sidang_id', $sidang->id)
                ->get();
        } else {
            if (Schema::hasTable('nilai_dosen_penguji')) {
                $nilaiPenguji = DB::table('nilai_dosen_penguji')
                    ->where('sidang_id', $sidang->id)
                    ->get();
            } else {
                $nilaiPenguji = collect(); // Empty collection
            }
        }

        return view('nilai.sekretaris', [
            'ta' => $ta,
            'sidang' => $sidang,
            'nilaiPembimbing' => $nilaiPembimbing,
            'nilaiPenguji' => $nilaiPenguji
        ]);
    }

    /**
     * Store pembimbing nilai
     */
    public function storePembimbing(Request $request, $ta_id, $sidang_id)
    {
        $dosen = Dosen::where('user_id', auth()->id())->first();
        if (!$dosen) {
            abort(403, 'Akses ditolak: Data dosen tidak ditemukan.');
        }

        $request->validate([
            'nilai_kedisiplinan' => 'nullable|numeric|min:0|max:100',
            'nilai_kreativitas' => 'nullable|numeric|min:0|max:100',
            'nilai_penguasaan_materi' => 'nullable|numeric|min:0|max:100',
            'nilai_kelengkapan' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'nullable|string'
        ]);

        // Check if table exists before saving - support both table names
        if (Schema::hasTable('unsur_nilai_pembimbing') || Schema::hasTable('unsur_nilai_dosen_pembimbing')) {
            $table = Schema::hasTable('unsur_nilai_pembimbing') ? 'unsur_nilai_pembimbing' : 'unsur_nilai_dosen_pembimbing';

            // Use DB query to update or create since we're dealing with potentially different table names
            DB::table($table)->updateOrInsert(
                [
                    'sidang_id' => $sidang_id,
                    'dosen_nip' => $dosen->dosen_nip,
                ],
                [
                    'nilai_kedisiplinan' => $request->nilai_kedisiplinan,
                    'nilai_kreativitas' => $request->nilai_kreativitas,
                    'nilai_penguasaan_materi' => $request->nilai_penguasaan_materi,
                    'nilai_kelengkapan' => $request->nilai_kelengkapan,
                    'catatan' => $request->catatan,
                ]
            );
        }

        return redirect()->back()->with('success', 'Nilai pembimbing berhasil disimpan.');
    }

    /**
     * Store penguji nilai
     */
    public function storePenguji(Request $request, $ta_id, $sidang_id)
    {
        $dosen = Dosen::where('user_id', auth()->id())->first();
        if (!$dosen) {
            abort(403, 'Akses ditolak: Data dosen tidak ditemukan.');
        }

        $request->validate([
            'nilai_ta' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'nullable|string'
        ]);

        // Check if nilai_penguji table exists (using the new table we created)
        if (Schema::hasTable('unsur_nilai_penguji') || Schema::hasTable('unsur_nilai_dosen_penguji')) {
            $table = Schema::hasTable('unsur_nilai_penguji') ? 'unsur_nilai_penguji' : 'unsur_nilai_dosen_penguji';
            DB::table($table)->updateOrInsert(
                [
                    'sidang_id' => $sidang_id,
                    'dosen_nip' => $dosen->dosen_nip,
                ],
                [
                    'nilai' => $request->nilai_ta,
                    'catatan' => $request->catatan,
                ]
            );
        } else {
            // Fallback to old table (for backward compatibility)
            if (Schema::hasTable('nilai_dosen_penguji')) {
                DB::table('nilai_dosen_penguji')->updateOrInsert(
                    [
                        'sidang_id' => $sidang_id,
                        'dosen_nip' => $dosen->dosen_nip,
                    ],
                    [
                        'nilai' => $request->nilai_ta,
                        'catatan' => $request->catatan,
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Nilai penguji berhasil disimpan.');
    }
}