<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\NilaiDosenPembimbing;
use App\Models\NilaiDosenPenguji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller;
use App\Models\SidangTugasAkhir;
use App\Models\TugasAkhir;
use App\Models\DosenPenguji;
use App\Models\Mahasiswa;

class SidangController extends Controller
{
    public function index()
    {
        $dosen = Dosen::where('user_id', auth()->id())->first();
        if (!$dosen) abort(404);

        // Get all sidang related to this dosen in various roles (pembimbing, penguji, sekretaris)
        // Using the scope to find all sidang related to this dosen
        $query = SidangTugasAkhir::with(['tugasAkhir']);

        // Conditionally load dosenPenguji relation only if table exists
        if (Schema::hasTable('dosen_penguji')) {
            $query->with(['dosenPenguji']);
        }

        $daftarSidang = $query->terkaitDosen($dosen->dosen_nip)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Enhance the data with mahasiswa information through alternative methods if needed
        foreach ($daftarSidang as $sidang) {
            if ($sidang->tugasAkhir) {
                // Check if mahasiswa relationship is already loaded and valid
                if (!$sidang->tugasAkhir->relationLoaded('mahasiswa') || !$sidang->tugasAkhir->mahasiswa) {
                    // Try alternative method - look up through tugas_akhir_anggota
                    $taAnggota = DB::table('tugas_akhir_anggota')
                        ->where('tugas_akhir_id', $sidang->tugasAkhir->id)
                        ->first();

                    if ($taAnggota) {
                        $mahasiswa = Mahasiswa::where('mhs_nim', $taAnggota->mhs_nim)->first();
                        if ($mahasiswa) {
                            // Assign the mahasiswa data directly to the relation
                            $sidang->tugasAkhir->setRelation('mahasiswa', $mahasiswa);
                        }
                    }
                }
            }
        }

        // Pass schema information to the view
        $schemaInfo = [
            'hasPembimbingCols' => Schema::hasColumn('tugas_akhir', 'pembimbing_1_nip') &&
                                  Schema::hasColumn('tugas_akhir', 'pembimbing_2_nip'),
            'hasPengujiCols' => Schema::hasColumn('sidang_tugas_akhir', 'penguji_1_nip') &&
                               Schema::hasColumn('sidang_tugas_akhir', 'penguji_2_nip') &&
                               Schema::hasColumn('sidang_tugas_akhir', 'penguji_3_nip'),
            'hasSekretarisCol' => Schema::hasColumn('sidang_tugas_akhir', 'sekretaris_nip'),
            'hasDosenPengujiTable' => Schema::hasTable('dosen_penguji'),
        ];

        return view('sidang.index', compact('daftarSidang', 'schemaInfo'));
    }

    public function store(Request $request)
    {
        $dosen = Dosen::where('user_id', auth()->id())->first();

        if (!$dosen) {
            return abort(404, 'Data Dosen tidak ditemukan');
        }

        // Determine if the logged-in dosen is pembimbing or penguji for this sidang
        $sidang = SidangTugasAkhir::find($request->sidang_id);
        if (!$sidang) {
            return abort(404, 'Sidang tidak ditemukan');
        }

        // Check if the dosen is pembimbing using the bimbingan table
        $isPembimbing = DB::table('bimbingan')
            ->where('tugas_akhir_id', $sidang->tugasAkhir->id)
            ->where('dosen_nip', $dosen->dosen_nip)
            ->exists();

        if ($isPembimbing) {
            // Save nilai for pembimbing
            // Only save if the table exists
            if (Schema::hasTable('unsur_nilai_pembimbing') || Schema::hasTable('unsur_nilai_dosen_pembimbing')) {
                NilaiDosenPembimbing::updateOrCreate(
                    [
                        'sidang_id' => $request->sidang_id,
                        'dosen_nip' => $dosen->dosen_nip,
                        'unsur_id'  => $request->unsur_id ?? 1
                    ],
                    [
                        // Kolom database 'nilai' diisi dari input 'nilai_angka'
                        'nilai' => $request->nilai_angka
                    ]
                );
            }
        } else {
            // Save nilai for penguji
            // Only save if the table exists
            if (Schema::hasTable('unsur_nilai_penguji') || Schema::hasTable('unsur_nilai_dosen_penguji')) {
                NilaiDosenPenguji::updateOrCreate(
                    [
                        'sidang_id' => $request->sidang_id,
                        'dosen_nip' => $dosen->dosen_nip,
                        'unsur_id'  => $request->unsur_id ?? 1
                    ],
                    [
                        // Kolom database 'nilai' diisi dari input 'nilai_angka'
                        'nilai' => $request->nilai_angka
                    ]
                );
            }
        }

        return back()->with('success', 'Nilai berhasil disimpan!');
    }

    /**
     * Determine the role of a dosen in a specific TA
     */
    public function determineRole($ta_id)
    {
        $dosen = Dosen::where('user_id', auth()->id())->first();
        if (!$dosen) {
            return response()->json(['error' => 'Dosen not found'], 404);
        }

        $ta = TugasAkhir::with('sidang')->findOrFail($ta_id);
        $sidang = $ta->sidang;

        if (!$sidang) {
            return response()->json(['error' => 'Sidang not found'], 404);
        }

        $role = $this->checkUserRole($dosen->dosen_nip, $ta, $sidang);

        return response()->json(['role' => $role]);
    }

    /**
     * Check the role of a dosen in a TA
     */
    private function checkUserRole($nip, $ta, $sidang)
    {
        // Check if pembimbing columns exist in the tugas_akhir table
        $pembimbingColsExist = Schema::hasColumn('tugas_akhir', 'pembimbing_1_nip') &&
                               Schema::hasColumn('tugas_akhir', 'pembimbing_2_nip');

        // Check if dosen is pembimbing 1 or 2
        if ($pembimbingColsExist && ($ta->pembimbing_1_nip === $nip || $ta->pembimbing_2_nip === $nip)) {
            return 'pembimbing';
        }

        // Check the bimbingan table for association (this is the primary approach now)
        $bimbingan = DB::table('bimbingan')
            ->where('tugas_akhir_id', $ta->id)
            ->where('dosen_nip', $nip)
            ->first();

        if ($bimbingan) {
            return 'pembimbing';
        }

        // Check if dosen_penguji table exists (this is the primary approach for examiners)
        if (Schema::hasTable('dosen_penguji')) {
            $dosenPenguji = DosenPenguji::where('sidang_id', $sidang->id)
                ->where('dosen_nip', $nip)
                ->first();
            if ($dosenPenguji) {
                return 'penguji';
            }
        } else {
            // Fallback: check penguji columns in sidang_tugas_akhir table
            $pengujiColsExist = Schema::hasColumn('sidang_tugas_akhir', 'penguji_1_nip') &&
                                Schema::hasColumn('sidang_tugas_akhir', 'penguji_2_nip') &&
                                Schema::hasColumn('sidang_tugas_akhir', 'penguji_3_nip');

            if ($pengujiColsExist && (
                $sidang->penguji_1_nip === $nip ||
                $sidang->penguji_2_nip === $nip ||
                $sidang->penguji_3_nip === $nip
            )) {
                return 'penguji';
            }
        }

        // Check if sekretaris column exists and if dosen is sekretaris
        $sekretarisColExists = Schema::hasColumn('sidang_tugas_akhir', 'sekretaris_nip');
        if ($sekretarisColExists && $sidang->sekretaris_nip === $nip) {
            return 'sekretaris';
        }

        return 'none';
    }
}