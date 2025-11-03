<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\JadwalSidang; // <-- Model utama kita
use App\Models\SidangTugasAkhir; // Kita juga perlu ini
use Carbon\Carbon; // Untuk format jam

class JadwalSidangController extends Controller
{
    public function index(Request $request)
    {
        // 1. Validasi input
        try {
            $validated = $request->validate([
                'tanggal' => 'required|date_format:Y-m-d',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Format tanggal tidak valid.',
                'errors' => $e->errors(),
            ], 422);
        }

        $tanggalDipilih = $validated['tanggal'];

        // 2. Query Eloquent (The Magic)
        // Kita mulai dari JadwalSidang yang tanggalnya cocok
        $jadwals = JadwalSidang::whereDate('tanggal', $tanggalDipilih)
            ->with([
                // Load relasi-relasi yang kita butuhin
                'ruangan', // Dapat tempat
                'sesi',    // Dapat jam
                
                // Ini relasi bersarang (nested)
                'sidangTugasAkhir.tugasAkhir.anggota.mahasiswa.prodi',
                'sidangTugasAkhir.tugasAkhir.bimbingan.dosen',
                'sidangTugasAkhir.penguji.dosen'
            ])
            ->get();

        // 3. Transformasi Data
        // Hasil query-nya kompleks, kita "ratakan" jadi JSON simpel
        
        $data = [];
        
        // Looping tiap jadwal (misal: Sesi 1 di Ruang A)
        foreach ($jadwals as $jadwal) {
            
            // Looping tiap sidang di dalam jadwal itu
            foreach ($jadwal->sidangTugasAkhir as $sidang) {
                
                // Ambil data-data yang kita butuhin
                $ta = $sidang->tugasAkhir;
                
                // Asumsi 1 TA 1 Anggota, atau kita ambil yg pertama
                $anggota = $ta->anggota->first(); 
                
                if (!$anggota) continue; // Skip jika TA tidak punya anggota
                
                $mahasiswa = $anggota->mahasiswa;

                // Format data sesuai rancangan
                $data[] = [
                    'id_sidang'   => $sidang->id,
                    'nama'        => $mahasiswa->mhs_nama,
                    'nim'         => $mahasiswa->mhs_nim,
                    'jurusan'     => $mahasiswa->prodi->nama_prodi,
                    'judul'       => $ta->judul,
                    'deskripsi'   => $ta->deskripsi ?? '-',
                    
                    'tanggal'     => $jadwal->tanggal, // Tipe Date
                    'jam'         => Carbon::parse($jadwal->sesi->waktu_mulai)->format('H:i') . ' WIB',
                    'tempat'      => $jadwal->ruangan->nama_ruangan,
                    
                    // Ambil 'dosen_nama' dari tiap relasi bimbingan
                    'pembimbing'  => $ta->bimbingan->map(function ($b) {
                        return $b->dosen->dosen_nama;
                    }),
                    
                    // Ambil 'dosen_nama' dari tiap relasi penguji
                    'penguji'     => $sidang->penguji->map(function ($p) {
                        return $p->dosen->dosen_nama;
                    }),
                ];
            }
        }
        
        // Urutkan hasil akhir berdasarkan jam
        usort($data, function($a, $b) {
            return strtotime($a['jam']) - strtotime($b['jam']);
        });

        // 4. Kirim Respon
        return response()->json($data);
    }
}