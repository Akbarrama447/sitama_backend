@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Penilaian Sidang</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>Mahasiswa</th>
                <th>Judul & Jadwal</th>
                <th>Peran Saya</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($daftarSidang as $s)
            <tr>
                {{-- Nama --}}
                <td>
                    @php
                        $mahasiswa_nama = 'N/A';
                        $mahasiswa_nim = 'N/A';

                        if (isset($s->tugasAkhir) && $s->tugasAkhir) {
                            // Try to get mahasiswa data from the enhanced relationship
                            if (isset($s->tugasAkhir->mahasiswa) && $s->tugasAkhir->mahasiswa) {
                                $mahasiswa_nama = $s->tugasAkhir->mahasiswa->mhs_nama ?? 'N/A';
                                $mahasiswa_nim = $s->tugasAkhir->mahasiswa->mhs_nim ?? 'N/A';
                            } else {
                                // If not available, try to get from the TA directly (in case there are other naming conventions)
                                $mahasiswa_nama = $s->tugasAkhir->mhs_nama ?? 'N/A';
                                $mahasiswa_nim = $s->tugasAkhir->mhs_nim ?? 'N/A';
                            }
                        }
                    @endphp
                    <strong>{{ $mahasiswa_nama }}</strong><br>
                    <small>{{ $mahasiswa_nim }}</small>
                </td>

                {{-- Judul --}}
                <td>
                    {{ $s->tugasAkhir->judul ?? 'N/A' }} <br>
                    <span class="badge bg-info">{{ $s->status ?? 'Belum Ada Jadwal' }}</span>
                </td>

                {{-- Peran Saya --}}
                <td class="text-center">
                    @php
                        $ta = $s->tugasAkhir;
                        $dosen = \App\Models\Dosen::where('user_id', auth()->id())->first();
                        $role = 'Tidak Ada';

                        if ($ta && $dosen) {
                            // Use schema info passed from controller
                            if ($schemaInfo['hasPembimbingCols'] && ($ta->pembimbing_1_nip === $dosen->dosen_nip || $ta->pembimbing_2_nip === $dosen->dosen_nip)) {
                                $role = 'Pembimbing';
                            }
                            // If pembimbing columns don't exist, check the bimbingan table
                            elseif (!$schemaInfo['hasPembimbingCols']) {
                                $bimbinganCount = DB::table('bimbingan')
                                    ->where('tugas_akhir_id', $ta->id)
                                    ->where('dosen_nip', $dosen->dosen_nip)
                                    ->count();
                                if ($bimbinganCount > 0) {
                                    $role = 'Pembimbing';
                                }
                            }
                            // Check if dosen_penguji table exists
                            elseif ($schemaInfo['hasDosenPengujiTable'] && $s->dosenPenguji && $s->dosenPenguji->contains('dosen_nip', $dosen->dosen_nip)) {
                                $role = 'Penguji';
                            }
                            // Fallback: check penguji columns in sidang table
                            elseif (!$schemaInfo['hasDosenPengujiTable']) {
                                if ($schemaInfo['hasPengujiCols'] && (
                                    $s->penguji_1_nip === $dosen->dosen_nip ||
                                    $s->penguji_2_nip === $dosen->dosen_nip ||
                                    $s->penguji_3_nip === $dosen->dosen_nip
                                )) {
                                    $role = 'Penguji';
                                }
                            }
                            // Check if sekretaris column exists
                            elseif ($schemaInfo['hasSekretarisCol'] && $s->sekretaris_nip === $dosen->dosen_nip) {
                                $role = 'Sekretaris';
                            }
                        }
                    @endphp
                    <span class="badge bg-primary">{{ $role }}</span>
                </td>

                {{-- Tombol Input Nilai --}}
                <td>
                    <a href="{{ route('nilai.show', $s->tugasAkhir->id) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil"></i> Input Nilai
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection