@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    {{-- Header: NIM & Nama --}}
    <div>
        <a href="{{ route('bimbingan.index') }}" class="btn btn-warning btn-sm fw-bold shadow-sm px-3">
                <i class="fas fa-angle-double-left me-1"></i> Kembali
            </a>
    </div>
    <div class="card mb-3 border-0 shadow-sm border-top border-primary border-4">
        <div class="card-body d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold text-dark">
                {{ $ta->mahasiswa->mhs_nim ?? '-' }} - {{ strtoupper($ta->mahasiswa->mhs_nama ?? $ta->mhs_nama) }}
            </h6>

        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between mb-3">
                <div class="d-flex align-items-center">
                    <span class="me-2 small">Show</span>
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option>10</option>
                    </select>
                    <span class="ms-2 small">entries</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="me-2 small">Search:</span>
                    <input type="text" class="form-control form-control-sm">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr class="text-secondary small">
                            <th width="50" class="text-center">No <i class="fas fa-sort float-end mt-1 opacity-25"></i></th>
                            <th>Judul Bimbingan <i class="fas fa-sort float-end mt-1 opacity-25"></i></th>
                            <th>Deskripsi <i class="fas fa-sort float-end mt-1 opacity-25"></i></th>
                            <th>Tanggal <i class="fas fa-sort float-end mt-1 opacity-25"></i></th>
                            <th width="150" class="text-center">File <i class="fas fa-sort float-end mt-1 opacity-25"></i></th>
                            <th width="100" class="text-center">Status <i class="fas fa-sort float-end mt-1 opacity-25"></i></th>
                            <th width="80" class="text-center">Aksi <i class="fas fa-sort float-end mt-1 opacity-25"></i></th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($list as $index => $item)
                        <tr>
                            <td class="text-center text-muted">{{ $index + 1 }}</td>
                            <td class="fw-bold">Bimbingan Bab {{ $index + 1 }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</td>
                            <td class="text-center">
                                <span class="badge bg-primary rounded-1 py-1 px-2 fw-normal" style="font-size: 10px;">Tidak ada lampiran</span>
                            </td>
                            <td class="text-center">
                                @if($item->status == 1)
                                    <span class="badge bg-success rounded-1" style="font-size: 10px;">Valid</span>
                                @elseif($item->status == 2)
                                    <span class="badge bg-danger rounded-1" style="font-size: 10px;">Invalid</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-1" style="font-size: 10px;">Pending</span>
                                @endif
                            </td>
                            <td class="text-center">
                              @if($item->status == 0)
    <div class="d-flex gap-2 justify-content-center">
        {{-- Tombol Verifikasi --}}
        <form action="{{ route('bimbingan.verify', $item->id) }}" method="POST">
            @csrf
            <button class="btn btn-success btn-sm shadow-sm d-flex align-items-center justify-content-center" 
                    title="Verifikasi Valid"
                    onclick="return confirm('Verifikasi bimbingan ini?')"
                    style="width: 32px; height: 32px; border-radius: 8px;">
                <i class="fas fa-check fa-lg"></i>
            </button>
        </form>

        {{-- Tombol Reject --}}
        <form action="{{ route('bimbingan.reject', $item->id) }}" method="POST">
            @csrf
            <button class="btn btn-danger btn-sm shadow-sm d-flex align-items-center justify-content-center" 
                    title="Tolak / Invalid"
                    onclick="return confirm('Tolak bimbingan ini?')"
                    style="width: 32px; height: 32px; border-radius: 8px;">
                <i class="fas fa-times fa-lg"></i>
            </button>
        </form>
    </div>
@endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-4">Showing 0 to 0 of 0 entries</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3 d-flex justify-content-between align-items-center small">
                <span>Showing {{ $list->count() > 0 ? '1' : '0' }} to {{ $list->count() }} of {{ $list->count() }} entries</span>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    {{-- Summary Card: Jumlah Bimbingan --}}
    <div class="card border-0 shadow-sm border-top border-primary border-4">
        <div class="card-header bg-white py-2 border-bottom">
            <h6 class="mb-0 fw-bold">Jumlah Bimbingan</h6>
        </div>
        <div class="card-body py-3">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1 fw-bold small">Pembimbing {{ $bimbingan->urutan }}</p>
                    <div class="d-flex align-items-center">
                        <span class="small me-3 text-dark">{{ $dosen->dosen_nama }}</span>
                        <span class="fw-bold small">: {{ $jumlahApproved }}/{{ $minBimbingan }}</span>
                        <span class="badge {{ $jumlahApproved >= $minBimbingan ? 'bg-success' : 'bg-warning text-dark' }} ms-2" style="font-size: 10px;">
                            {{ $jumlahApproved >= $minBimbingan ? 'Terpenuhi' : 'Belum Terpenuhi' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-3">

@if($jumlahApproved >= $minBimbingan)
    <div class="alert alert-success py-2 px-3 small border-0 shadow-sm mt-3 d-flex align-items-center">
        <i class="fas fa-check-circle fa-lg me-2"></i>
        <div>
            <strong>Status: Siap Sidang</strong><br>
            Mahasiswa sudah memenuhi syarat dan dapat mengunduh Surat Keterangan.
        </div>
    </div>
@else
    <div class="alert alert-light border py-2 px-3 small mt-3 text-muted d-flex align-items-center">
        <i class="fas fa-lock me-2"></i>
        <div>
            <strong>Status: Belum Siap</strong><br>
            Menunggu {{ $minBimbingan - $jumlahApproved }} bimbingan valid lagi.
        </div>
    </div>
@endif
    </div><div class="card mt-4 border-0 shadow-sm border-top border-primary border-4">
    
    </div>
</div>


<style>
    body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .table thead th { border-bottom: 2px solid #dee2e6; background-color: #f8f9fa; font-weight: 600; color: #495057; }
    .table-bordered td, .table-bordered th { border: 1px solid #e9ecef; }
    .btn-warning { background-color: #ffc107; color: #000; border: none; }
    .btn-warning:hover { background-color: #e0a800; }
    .card { border-radius: 4px; }
    .badge { padding: 4px 8px; font-weight: 600; }
    .text-primary { color: #007bff !important; }
</style>
@endsection