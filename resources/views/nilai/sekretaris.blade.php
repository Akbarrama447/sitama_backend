@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('sidang.index') }}" class="btn btn-sm btn-secondary mb-2">← Kembali</a>
    <h4>Daftar Nilai - {{ $ta->mahasiswa->mhs_nama ?? $ta->mhs_nama }}</h4>
    <p><strong>Judul:</strong> {{ $ta->judul }}</p>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Nilai Pembimbing</h5>
                </div>
                <div class="card-body">
                    @if($nilaiPembimbing->count() > 0)
                        @foreach($nilaiPembimbing as $nilai)
                        <div class="nilai-item mb-3">
                            @php
                                $dosen = \App\Models\Dosen::where('dosen_nip', $nilai->dosen_nip)->first();
                            @endphp
                            <p><strong>Dosen:</strong> {{ $dosen ? $dosen->dosen_nama : 'N/A' }}</p>
                            <p><strong>Kerajinan:</strong> {{ $nilai->kerajinan_nilai ?? 'Belum Dinilai' }}</p>
                            <p><strong>Keteguhan:</strong> {{ $nilai->keteguhan_nilai ?? 'Belum Dinilai' }}</p>
                            <p><strong>Kemajuan:</strong> {{ $nilai->kemajuan_nilai ?? 'Belum Dinilai' }}</p>
                            <p><strong>Total:</strong> {{ $nilai->total_nilai ?? 'Belum Dinilai' }}</p>
                            <p><strong>Catatan:</strong> {{ $nilai->catatan ?? '-' }}</p>
                        </div>
                        @endforeach
                    @else
                        <p>Belum ada nilai dari pembimbing</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Nilai Penguji</h5>
                </div>
                <div class="card-body">
                    @if($nilaiPenguji->count() > 0)
                        @foreach($nilaiPenguji as $nilai)
                        <div class="nilai-item mb-3">
                            @php
                                $dosen = \App\Models\Dosen::where('dosen_nip', $nilai->dosen_nip)->first();
                            @endphp
                            <p><strong>Dosen Penguji:</strong> {{ $dosen ? $dosen->dosen_nama : 'N/A' }}</p>
                            <p><strong>Nilai TA:</strong> {{ $nilai->nilai ?? 'Belum Dinilai' }}</p>
                            <p><strong>Catatan:</strong> {{ $nilai->catatan ?? '-' }}</p>
                        </div>
                        @endforeach
                    @else
                        <p>Belum ada nilai dari penguji</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection