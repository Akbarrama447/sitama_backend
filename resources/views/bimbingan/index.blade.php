@extends('layouts.app') 

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Mahasiswa Bimbingan Tugas Akhir</h1>
    
    {{-- Filter Section (Visual Saja) --}}
    <div class="card mb-4 mt-3 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <select class="form-select form-select-sm">
                        <option>2024/2025</option>
                        <option>2023/2024</option>
                    </select>
                </div>
                <div class="col-auto">
                    <select class="form-select form-select-sm">
                        <option>All Program Studi</option>
                        <option>Teknik Informatika</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary btn-sm">Filter</button>
                </div>
            </div>
        </div>

        <div class="card-body">
            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center" width="5%">No</th>
                            <th scope="col" width="10%">NIM</th>
                            <th scope="col" width="20%">Mahasiswa</th>
                            <th scope="col" width="30%">Judul TA</th>
                            <th scope="col" class="text-center" width="10%">Tahun Akademik</th>
                            <th scope="col" class="text-center" width="10%">Sebagai</th>
                            <th scope="col" class="text-center" width="10%">Persetujuan Sidang Akhir</th>
                            <th scope="col" class="text-center" width="5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bimbingan as $b)
                        <tr>
                            {{-- 1. No --}}
                            <td class="text-center">{{ $loop->iteration + $bimbingan->firstItem() - 1 }}</td>
                            
                            {{-- 2. NIM --}}
                            <td>{{ $b->mhs_nim }}</td>
                            
                            {{-- 3. Mahasiswa --}}
                            <td class="fw-bold">
                                {{ $b->mhs_nama }}
                            </td>
                            
                            {{-- 4. Judul TA --}}
                            <td>
                                <small class="text-muted d-block" style="line-height: 1.2;">
                                    {{ Str::limit($b->judul_ta, 100) }}
                                </small>
                            </td>
                            
                            {{-- 5. Tahun Akademik --}}
                            <td class="text-center">{{ $b->tahun_akademik ?? '-' }}</td>
                            
                            {{-- 6. Sebagai --}}
                            <td class="text-center">
                                <span class="badge bg-light text-dark border">
                                    Pembimbing {{ $b->urutan }}
                                </span>
                            </td>

                            {{-- 7. Persetujuan Sidang (Logic: Minimal 8 Verified) --}}
                            <td class="text-center">
                                @if($b->jumlah_verified >= 8)
                                    <span class="badge bg-success rounded-pill px-3">
                                        <i class="fas fa-check-circle me-1"></i> Syarat Terpenuhi ({{ $b->jumlah_verified }})
                                    </span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3">
                                        Belum Cukup ({{ $b->jumlah_verified }}/8)
                                    </span>
                                @endif
                            </td>

                            {{-- 8. Aksi (Tombol Biru) --}}
                            <td class="text-center">
                                <a href="{{ route('bimbingan.show', $b->ta_id) }}" class="btn btn-primary btn-sm" title="Lihat Detail">
                                    <i class="fas fa-list"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                Tidak ada data mahasiswa bimbingan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="mt-3 d-flex justify-content-end">
                {{ $bimbingan->links() }}
            </div>
        </div>
    </div>
</div>
@endsection