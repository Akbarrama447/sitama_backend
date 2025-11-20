@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Penilaian Sidang (Dosen Pembimbing)</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>Mahasiswa</th>
                <th>Judul & Jadwal</th>
                <th>Nilai </th>
                <th>Keputusan</th>
                {{-- Kolom Revisi Dihapus karena tidak ada di DB baru --}}
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sidang as $s)
            <tr>
                {{-- Nama --}}
                <td>
                    <strong>{{ $s->mhs_nama }}</strong><br>
                    <small>{{ $s->mhs_nim }}</small>
                </td>

                {{-- Judul --}}
                <td>
                    {{ $s->judul }} <br>
                    <span class="badge bg-info">{{ $s->status_jadwal }}</span>
                </td>

                {{-- Nilai (SINKRON: Panggil 'nilai') --}}
                <td class="text-center fw-bold">
                    {{ $s->nilai ?? '-' }}
                </td>

                {{-- Status (SINKRON: Panggil 'nilai') --}}
                <td class="text-center">
                    @if($s->nilai === null)
                        <span class="badge bg-secondary">Belum Dinilai</span>
                    @elseif($s->nilai > 75)
                        <span class="badge bg-success">Lulus</span>
                    @else
                        <span class="badge bg-warning text-dark">Revisi</span>
                    @endif
                </td>

                {{-- Kolom Revisi Dihapus --}}

                {{-- Tombol DAN MODAL (INI PERBAIKANNYA) --}}
                <td>
                    {{-- 1. TOMBOL --}}
                    <button type="button" class="btn btn-primary btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalNilai{{ $s->sidang_id }}">
                        <i class="bi bi-pencil"></i> {{ $s->nilai_id ? 'Edit Nilai' : 'Input Nilai' }}
                    </button>
                    
                    {{-- 2. MODAL DIPINDAH KE DALAM TD --}}
                    <div class="modal fade" id="modalNilai{{ $s->sidang_id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('sidang.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Nilai Sidang: {{ $s->mhs_nama }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        {{-- ID Sidang (Hidden) --}}
                                        <input type="hidden" name="sidang_id" value="{{ $s->sidang_id }}">

                                        <div class="mb-3">
                                            <label>Nilai Angka (0-100)</label>
                                            
                                            {{-- SINKRON: name="nilai_angka" agar dibaca Controller --}}
                                            {{-- SINKRON: value="{{ $s->nilai }}" --}}
                                            <input type="number" name="nilai_angka" class="form-control" 
                                                   step="0.01" min="0" max="100" required value="{{ $s->nilai }}">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- AKHIR DARI MODAL --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection