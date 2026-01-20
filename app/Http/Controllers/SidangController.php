<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\SidangTugasAkhir;
use App\Models\TugasAkhir;
use App\Models\NilaiDosenPembimbing;
use App\Models\NilaiDosenPenguji;
use App\Models\UnsurPenilaianPembimbing;
use App\Models\UnsurPenilaianPenguji;
use App\Models\RevisiTugasAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SidangController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $dosen = Dosen::where('user_id', $user->id)->first();

        // Jika bukan dosen (misal admin murni), tampilkan semua atau kosongkan (tergantung kebijakan)
        // Di sini diasumsikan kalau admin mau liat semua, tapi kalau dosen hanya yg terkait
        if (!$dosen) {
             if($user->role == 'admin') {
                 // Admin lihat semua
                 $sidangs = SidangTugasAkhir::with([
                    'tugasAkhir.mahasiswa',
                    'tugasAkhir.bimbingan.dosen',
                    'dosenPengujis',
                    'jadwal.sesi',
                    'sekretaris'
                ])->orderBy('created_at', 'desc')->paginate(10);
             } else {
                 return redirect()->back()->with('error', 'Data Dosen tidak ditemukan.');
             }
        } else {
            // FILTER KHUSUS DOSEN
            $myNip = $dosen->dosen_nip;

            $sidangs = SidangTugasAkhir::with([
                'tugasAkhir.mahasiswa',
                'tugasAkhir.bimbingan.dosen',
                'dosenPengujis',
                'jadwal.sesi',
                'sekretaris'
            ])
            ->where(function($query) use ($myNip) {
                // 1. Cek apakah saya Pembimbing (Relasi via Tugas Akhir -> Bimbingan)
                $query->whereHas('tugasAkhir.bimbingan', function($q) use ($myNip) {
                    $q->where('dosen_nip', $myNip);
                })
                // 2. ATAU apakah saya Penguji (Relasi via Sidang -> DosenPenguji)
                ->orWhereHas('dosenPengujis', function($q) use ($myNip) {
                    $q->where('dosen_penguji.dosen_nip', $myNip); // Spesifik tabel pivot
                })
                // 3. ATAU apakah saya Sekretaris (Kolom sekretaris_nip di tabel sidang)
                ->orWhere('sekretaris_nip', $myNip);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        }

        // Transform data untuk badge status & peran (Logic tampilan tetap sama)
        $sidangs->getCollection()->transform(function ($sidang) use ($dosen) {
            // Kalau admin login tanpa data dosen, peran_user null/admin
            $nipCheck = $dosen ? $dosen->dosen_nip : null;

            $sidang->peran_user = $nipCheck ? $sidang->getPeranDosen($nipCheck) : 'Admin';

            $status = strtolower($sidang->status);
            $sidang->badge_status = match($status) {
                'lulus' => 'success',
                'tidak lulus', 'tidak_lulus' => 'danger',
                'revisi', 'lulus dengan revisi' => 'warning',
                'dijadwalkan' => 'info',
                default => 'primary'
            };
            return $sidang;
        });

        return view('sidang.index', compact('sidangs'));
    }

    public function show($id)
    {
        $user = Auth::user();

        // 1. AMBIL DATA SIDANG
        $sidang = SidangTugasAkhir::with('tugasAkhir.mahasiswa')->findOrFail($id);

        // 2. AMBIL NIP USER YANG LOGIN
        $dosen = Dosen::where('user_id', $user->id)->first();
        $myNip = $dosen ? $dosen->dosen_nip : null;

        // -------------------------------------------------------------
        // LOGIKA PENENTUAN HAK AKSES SEKRETARIS
        // -------------------------------------------------------------
        $isAdminOrStaff = ($user->role == 'sekretaris' || $user->role == 'admin');
        $isSekretarisSidang = ($myNip && trim($myNip) == trim($sidang->sekretaris_nip));

        if ($isAdminOrStaff || $isSekretarisSidang) {
            // PERBAIKAN: Tambahkan 'dosen' di dalam array with()
            $nilaiPembimbing = NilaiDosenPembimbing::with(['unsur', 'dosen'])->where('sidang_id', $id)->get();
            $nilaiPenguji = NilaiDosenPenguji::with(['unsur', 'dosen'])->where('sidang_id', $id)->get();

            return view('sidang.show_sekretaris', compact('sidang', 'nilaiPembimbing', 'nilaiPenguji'));
        }

        // -------------------------------------------------------------
        // CEK PENGUJI / PEMBIMBING
        // -------------------------------------------------------------
        if (!$myNip) {
            return abort(403, "Akses ditolak. Akun Anda tidak terhubung dengan Data Dosen.");
        }

        // Cek Penguji (Prioritas 1)
        $isPenguji = DB::table('dosen_penguji')
                     ->where('sidang_id', $id)
                     ->where('dosen_nip', $myNip)
                     ->exists();

        $ta_id = optional($sidang->tugasAkhir)->id;

        // Cek Pembimbing (Prioritas 2)
        $isPembimbing = DB::table('bimbingan')
                        ->where('tugas_akhir_id', $ta_id)
                        ->where('dosen_nip', $myNip)
                        ->exists();

        $contextRole = null;

        if ($isPenguji) {
            $contextRole = 'dosen_penguji';
            $unsurList = UnsurPenilaianPenguji::all();
            $existingNilai = NilaiDosenPenguji::where('sidang_id', $id)
                            ->where('dosen_nip', $myNip)
                            ->pluck('nilai', 'unsur_id')
                            ->toArray();

        } elseif ($isPembimbing) {
            $contextRole = 'dosen_pembimbing';
            $unsurList = UnsurPenilaianPembimbing::all();
            $existingNilai = NilaiDosenPembimbing::where('sidang_id', $id)
                            ->where('dosen_nip', $myNip)
                            ->pluck('nilai', 'unsur_id')
                            ->toArray();
        } else {
            abort(403, 'Akses Ditolak. Anda bukan Sekretaris, Penguji, ataupun Pembimbing di sidang ini.');
        }

        return view('sidang.show_dosen', compact('sidang', 'unsurList', 'existingNilai', 'contextRole'));
    }

    // =========================================================================
    // FITUR: FUNGSI HITUNG OTOMATIS (PRIVATE)
    // =========================================================================
    private function updateNilaiAkhirSidang($sidang_id)
    {
        // 1. Hitung Rata-rata Pembimbing
        $nilaiPembimbing = NilaiDosenPembimbing::with('unsur')->where('sidang_id', $sidang_id)->get();
        $groupedPembimbing = $nilaiPembimbing->groupBy('dosen_nip');

        $totalRataPembimbing = 0;
        $countPembimbing = $groupedPembimbing->count();

        if ($countPembimbing > 0) {
            $grandTotal = 0;
            foreach ($groupedPembimbing as $scores) {
                foreach ($scores as $item) {
                    $grandTotal += ($item->nilai * ($item->unsur->bobot / 100));
                }
            }
            $totalRataPembimbing = $grandTotal / $countPembimbing;
        }

        // 2. Hitung Rata-rata Penguji
        $nilaiPenguji = NilaiDosenPenguji::with('unsur')->where('sidang_id', $sidang_id)->get();
        $groupedPenguji = $nilaiPenguji->groupBy('dosen_nip');

        $totalRataPenguji = 0;
        $countPenguji = $groupedPenguji->count();

        if ($countPenguji > 0) {
            $grandTotal = 0;
            foreach ($groupedPenguji as $scores) {
                foreach ($scores as $item) {
                    $grandTotal += ($item->nilai * ($item->unsur->bobot / 100));
                }
            }
            $totalRataPenguji = $grandTotal / $countPenguji;
        }

        // 3. Hitung Nilai Akhir Gabungan
        // if ($countPembimbing > 0 && $countPenguji > 0) {
            $nilaiAkhir = ($totalRataPembimbing + $totalRataPenguji) / 2;
        // } elseif ($countPembimbing > 0) {
        //     $nilaiAkhir = $totalRataPembimbing;
        // } elseif ($countPenguji > 0) {
        //     $nilaiAkhir = $totalRataPenguji;
        // } else {
        //     $nilaiAkhir = 0;
        // }

        // 4. Update ke Tabel Utama (sidang_tugas_akhir)
        $sidang = SidangTugasAkhir::find($sidang_id);
        if ($sidang) {
            // PERBAIKAN: Kembali ke 'nilai_akhir'
            $sidang->nilai_akhir = round($nilaiAkhir, 2);
            $sidang->save();
        }
    }

    // =========================================================================
    // UPDATE STORE DOSEN (Panggil fungsi hitung di sini)
    // =========================================================================

    public function storePembimbing(Request $request, $sidang_id) {
        $dosen = Dosen::where('user_id', auth()->id())->firstOrFail();
        $request->validate([
            'skor' => 'required|array',
            'skor.*' => 'required|integer|min:0|max:100']);

        foreach ($request->skor as $unsur_id => $nilai) {
            NilaiDosenPembimbing::updateOrCreate(
                ['sidang_id' => $sidang_id, 'dosen_nip' => $dosen->dosen_nip, 'unsur_id' => $unsur_id],
                ['nilai' => $nilai]
            );
        }

        // Trigger Hitung Otomatis
        $this->updateNilaiAkhirSidang($sidang_id);

        return redirect()->back()->with('success', 'Nilai tersimpan & dikalkulasi ulang.');
    }

    public function storePenguji(Request $request, $sidang_id) {
        $dosen = Dosen::where('user_id', auth()->id())->firstOrFail();
        $request->validate([
            'skor' => 'required|array',
            'skor.*' => 'required|integer|min:0|max:100'
        ]);

        foreach ($request->skor as $unsur_id => $nilai) {
            NilaiDosenPenguji::updateOrCreate(
                ['sidang_id' => $sidang_id, 'dosen_nip' => $dosen->dosen_nip, 'unsur_id' => $unsur_id],
                ['nilai' => $nilai]
            );
        }

        // Trigger Hitung Otomatis
        $this->updateNilaiAkhirSidang($sidang_id);

        return redirect()->back()->with('success', 'Nilai tersimpan & dikalkulasi ulang.');
    }

    // =========================================================================
    // STORE SEKRETARIS (Status Only)
    // =========================================================================
    public function storeSekretaris(Request $request, $sidang_id)
    {
        $dosen = Dosen::where('user_id', auth()->id())->firstOrFail();
        $sidang = SidangTugasAkhir::findOrFail($sidang_id);

        // Validasi HANYA status kelulusan
        $request->validate([
            'status_kelulusan' => 'required|integer|between:1,4',
        ]);

        // Update Status saja, Nilai tidak disentuh
        $sidang->update([
            'status' => $request->status_kelulusan
        ]);

        // Ambil tugas akhir dan mahasiswa yang terlibat dalam sidang ini
        $tugasAkhir = $sidang->tugasAkhir;

        // Ambil mahasiswa yang terlibat dalam sidang ini (menggunakan mhs_nim dari tabel sidang_tugas_akhir)
        // Jika mhs_nim tidak tersedia di tabel sidang_tugas_akhir, kita gunakan mahasiswa pertama dari kelompok
        $mhs_nim = $sidang->mhs_nim; // Ambil nim mahasiswa dari kolom mhs_nim di tabel sidang_tugas_akhir

        if ($mhs_nim) {
            // Jika ada nim mahasiswa spesifik di record sidang, hanya update untuk mahasiswa tersebut
            $mahasiswa = $tugasAkhir->mahasiswa()->where('mahasiswa.mhs_nim', $mhs_nim)->first();

            if ($mahasiswa) {
                // Cek apakah sudah ada entri untuk tugas akhir ini dan mahasiswa ini
                $revisi = RevisiTugasAkhir::where('tugas_akhir_id', $tugasAkhir->id)
                    ->where('mhs_nim', $mahasiswa->mhs_nim)
                    ->first();

                if ($revisi) {
                    // Jika sudah ada, update statusnya
                    $revisi->update([
                        'status_revisi' => $request->status_kelulusan,
                        'dosen_nip' => $dosen->dosen_nip, // Gunakan NIP dosen sekretaris
                        'catatan_revisi' => 'Status kelulusan sidang: ' . $this->getStatusText($request->status_kelulusan), // Tambahkan catatan
                        'updated_at' => now() // Memastikan timestamp terbaru
                    ]);
                } else {
                    // Jika belum ada, buat entri baru
                    RevisiTugasAkhir::create([
                        'tugas_akhir_id' => $tugasAkhir->id,
                        'mhs_nim' => $mahasiswa->mhs_nim,
                        'dosen_nip' => $dosen->dosen_nip,
                        'catatan_revisi' => 'Status kelulusan sidang: ' . $this->getStatusText($request->status_kelulusan),
                        'status_revisi' => $request->status_kelulusan,
                        'file_revisi' => null, // Tidak ada file untuk status kelulusan
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        } else {
            // Jika tidak ada nim mahasiswa spesifik, kita tetap hanya update untuk mahasiswa pertama dari kelompok
            $mahasiswa = $tugasAkhir->mahasiswa()->first();

            if ($mahasiswa) {
                // Cek apakah sudah ada entri untuk tugas akhir ini dan mahasiswa ini
                $revisi = RevisiTugasAkhir::where('tugas_akhir_id', $tugasAkhir->id)
                    ->where('mhs_nim', $mahasiswa->mhs_nim)
                    ->first();

                if ($revisi) {
                    // Jika sudah ada, update statusnya
                    $revisi->update([
                        'status_revisi' => $request->status_kelulusan,
                        'dosen_nip' => $dosen->dosen_nip, // Gunakan NIP dosen sekretaris
                        'catatan_revisi' => 'Status kelulusan sidang: ' . $this->getStatusText($request->status_kelulusan), // Tambahkan catatan
                        'updated_at' => now() // Memastikan timestamp terbaru
                    ]);
                } else {
                    // Jika belum ada, buat entri baru
                    RevisiTugasAkhir::create([
                        'tugas_akhir_id' => $tugasAkhir->id,
                        'mhs_nim' => $mahasiswa->mhs_nim,
                        'dosen_nip' => $dosen->dosen_nip,
                        'catatan_revisi' => 'Status kelulusan sidang: ' . $this->getStatusText($request->status_kelulusan),
                        'status_revisi' => $request->status_kelulusan,
                        'file_revisi' => null, // Tidak ada file untuk status kelulusan
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Keputusan sidang berhasil disimpan!');
    }

    /**
     * Helper function untuk mendapatkan teks status berdasarkan angka
     */
    private function getStatusText($statusNumber)
    {
        switch ($statusNumber) {
            case 1:
                return 'Lulus';
            case 2:
                return 'Lulus dengan Revisi';
            case 3:
                return 'Revisi / Mengulang';
            case 4:
                return 'Tidak Lulus';
            default:
                return 'Status Tidak Dikenal';
        }
    }
}