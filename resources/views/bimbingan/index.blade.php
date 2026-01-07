@extends('layouts.app') 

@section('content')
<div class="container-fluid pt-2">
    <h3 class="mt-4">Data Mahasiswa Bimbingan Tugas Akhir</h3   >
    
    {{-- Card Wrapper --}}
    <div class="card mb-4 mt-3 shadow-sm border-0">
        
        {{-- Filter Section --}}
        <div class="card-header bg-white py-3">
            <form action="{{ route('bimbingan.index') }}" method="GET">
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <select name="tahun_akademik" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Semua Tahun</option>
                            <option value="2024/2025" {{ request('tahun_akademik') == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                            <option value="2023/2024" {{ request('tahun_akademik') == '2023/2024' ? 'selected' : '' }}>2023/2024</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select name="prodi_id" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Semua Program Studi</option>
                        
                        @foreach($prodis as $p)
                            <option value="{{ $p->id }}" {{ request('prodi_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_prodi }}
                            </option>
                        @endforeach
                    </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            {{-- Pesan Alert --}}
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
                            <td class="text-center">{{ $loop->iteration + $bimbingan->firstItem() - 1 }}</td>
                            <td>{{ $b->mhs_nim }}</td>
                            <td class="fw-bold">{{ $b->mhs_nama }}</td>
                            <td>
                                <small class="text-muted d-block" style="line-height: 1.2;">
                                    {{ Str::limit($b->judul_ta, 100) }}
                                </small>
                            </td>
                            <td class="text-center">{{ $b->tahun_akademik ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border">
                                    Pembimbing {{ $b->urutan }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($b->jumlahApproved >= 8)
                                    <span class="badge bg-success rounded-pill px-3">
                                        <i class="fas fa-check-circle me-1"></i> Syarat Terpenuhi ({{ $b->jumlahApproved }})
                                    </span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3">
                                        Belum Cukup ({{ $b->jumlahApproved }}/8)
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('bimbingan.show', ['ta' => $b->ta_id, 'mhs' => $b->mhs_nim]) }}" class="btn btn-primary btn-sm" title="Lihat Detail">
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
            
            <div class="mt-3 d-flex justify-content-end">
                {{ $bimbingan->links() }}
            </div>
        </div>
    </div>
</div>
@endsection