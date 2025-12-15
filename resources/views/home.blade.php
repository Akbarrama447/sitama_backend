@extends('layouts.app')

@section('content')
    {{-- Header Content --}}
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0 fw-light">Dashboard <small class="text-muted" style="font-size: 1rem;">Sistem Informasi Tugas Akhir</small></h1>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="content">
        <div class="container-fluid">
            
            {{-- Welcome Card (Classy & Rounded) --}}
            <div class="card bg-primary shadow-xl rounded-xl border-0 mb-5 text-white bg-gradient">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <h3 class="card-title fw-light">Selamat Datang, <span class="fw-bold">{{ ucwords(auth()->user()->name) }}</span>!</h3>
                            <p class="mb-0" style="opacity: 0.9;">
                                Peran Anda: <span class="badge bg-white text-primary rounded-pill">{{ auth()->user()->getRoleNames()->first() ?? 'User' }}</span>.
                                
                            </p>
                        </div>
                        <div class="col-md-3 text-right">
                            <i class="fas fa-rocket fa-4x text-white opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row 1: Key Performance Indicators (KPIs) - Minimalist & Rounded --}}
            <div class="row">
                
                {{-- KPI 1: Mahasiswa TA (Real Data) --}}
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-lg rounded-xl border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-secondary text-uppercase mb-1" style="font-size: 0.75rem;">Mahasiswa Bimbingan</div>
                                    <div class="h3 mb-0 fw-bold text-primary">{{ $stats['mahasiswa_aktif'] }}</div>
                                </div>
                                <i class="fas fa-users fa-2x text-primary opacity-50"></i>
                            </div>
                        </div>
                        <a href="{{ route('bimbingan.index') }}" class="card-footer bg-light text-primary rounded-bottom-xl pt-2 pb-2 small fw-bold text-center border-0">
                            <span>Detail &rarr;</span>
                        </a>
                    </div>
                </div>

                {{-- KPI 2: Log Bimbingan Baru (Real Data) --}}
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-lg rounded-xl border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-secondary text-uppercase mb-1" style="font-size: 0.75rem;">Log Bimbingan Baru</div>
                                    <div class="h3 mb-0 fw-bold text-success">{{ $stats['log_bimbingan_baru'] }}</div>
                                </div>
                                <i class="fas fa-comments fa-2x text-success opacity-50"></i>
                            </div>
                        </div>
                        <a href="{{ route('bimbingan.index') }}" class="card-footer bg-light text-success rounded-bottom-xl pt-2 pb-2 small fw-bold text-center border-0">
                            <span>Verifikasi Cepat &rarr;</span>
                        </a>
                    </div>
                </div>

                {{-- KPI 3: Jadwal Sidang (Real Data) --}}
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-lg rounded-xl border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-secondary text-uppercase mb-1" style="font-size: 0.75rem;">Sidang Terlibat</div>
                                    <div class="h3 mb-0 fw-bold text-warning">{{ $stats['tugas_sidang_total'] }}</div>
                                </div>
                                <i class="fas fa-calendar-alt fa-2x text-warning opacity-50"></i>
                            </div>
                        </div>
                        <a href="{{ route('sidang.index') }}" class="card-footer bg-light text-warning rounded-bottom-xl pt-2 pb-2 small fw-bold text-center border-0">
                            <span>Jadwal Lengkap &rarr;</span>
                        </a>
                    </div>
                </div>

                {{-- KPI 4: Tugas Penilaian Pending (Real Data) --}}
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card shadow-lg rounded-xl border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-secondary text-uppercase mb-1" style="font-size: 0.75rem;">Penilaian Pending</div>
                                    <div class="h3 mb-0 fw-bold text-danger">{{ $stats['tugas_penilaian_pending'] }}</div>
                                </div>
                                <i class="fas fa-gavel fa-2x text-danger opacity-50"></i>
                            </div>
                        </div>
                        <a href="{{ route('sidang.index') }}" class="card-footer bg-light text-danger rounded-bottom-xl pt-0 pb-2 small fw-bold text-center border-0">
                            <span>Input Nilai &rarr;</span>
                        </a>
                    </div>
                </div>
            </div> {{-- End Row KPIs --}}

            {{-- Row 2: Informasi & Quick Menu (Rounded & Clean) --}}
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary card-outline shadow-md rounded-xl h-100">
                        <div class="card-header bg-dark text-white rounded-top-xl">
                            <h5 class="m-0">Pengumuman Penting</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="card-title fw-bold">Total Judul TA Aktif: {{ $stats['arsip_judul'] }}</h6>
                            <p class="card-text text-muted">
                                Pendaftaran sidang periode Desember 2025 akan ditutup pada tanggal <strong>20 Desember 2025</strong>. 
                                Mohon segera lengkapi semua prasyarat dan nilai bimbingan.
                            </p>
                            <a href="#" class="btn btn-primary btn-sm rounded-pill bg-gradient"><i class="fas fa-bell me-1"></i> Lihat Detail Pengumuman</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card card-primary card-outline shadow-md rounded-xl h-100">
                        <div class="card-header bg-dark text-white rounded-top-xl">
                            <h5 class="m-0">Menu Aksi Cepat</h5>
                        </div>
                        <div class="card-body d-flex justify-content-start flex-wrap">
                            <a href="{{ route('bimbingan.index') }}" class="btn btn-app bg-success m-1 shadow-sm rounded-lg text-white">
                                <i class="fas fa-comments"></i> Verifikasi Bimbingan
                            </a>
                            <a href="{{ route('sidang.index') }}" class="btn btn-app bg-primary m-1 shadow-sm rounded-lg text-white">
                                <i class="fas fa-gavel"></i> Input Nilai Sidang
                            </a>
                            <a href="#" class="btn btn-app bg-info m-1 shadow-sm rounded-lg text-white">
                                <i class="fas fa-user"></i> Profil Saya
                            </a>
                            <a href="#" class="btn btn-app bg-secondary m-1 shadow-sm rounded-lg text-white">
                                <i class="fas fa-upload"></i> Upload Berkas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection