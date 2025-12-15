@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Tombol Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
        <a href="{{ route('sidang.index') }}" class="btn btn-outline-secondary btn-sm px-3 rounded-pill back-btn">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-0 fw-bold text-dark">Penilaian Sidang</h4>
    </div>

    {{-- HEADER INFORMASI --}}
    <div class="mb-4">
        <h4>
            Penilaian -
            <span class="fw-bold">{{ $sidang->tugasAkhir->mahasiswa->mhs_nama ?? 'Nama Mahasiswa' }}</span>
        </h4>
        <div class="text-muted">
            <strong>Judul TA:</strong> {{ $sidang->tugasAkhir->judul ?? '-' }} <br>
            <strong>Peran Anda:</strong>
            @if($contextRole == 'dosen_pembimbing')
                <span class="badge bg-success">Dosen Pembimbing</span>
            @else
                <span class="badge bg-primary">Dosen Penguji</span>
            @endif
        </div>
    </div>

    {{-- LOGIC FORM ACTION --}}
    <form method="POST"
          action="{{ $contextRole == 'dosen_pembimbing' ? route('sidang.storePembimbing', $sidang->id) : route('sidang.storePenguji', $sidang->id) }}">
        @csrf

        <div class="row">
            {{-- KOLOM KIRI: FORM INPUT NILAI --}}
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    {{-- Header Card Berubah Warna Sesuai Role --}}
                    <div class="card-header text-white {{ $contextRole == 'dosen_pembimbing' ? 'bg-success' : 'bg-primary' }}">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-1"></i> Form Penilaian {{ $contextRole == 'dosen_pembimbing' ? 'Pembimbing' : 'Penguji' }}
                        </h5>
                    </div>

                    <div class="card-body">
                        {{-- Alert Error Validation --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- ALERT SUKSES --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- LOOPING DINAMIS (INTI LOGIKA) --}}
                        @foreach($unsurList as $index => $unsur)
                        <div class="form-group mb-4">
                            <label for="skor_{{ $unsur->id }}" class="form-label fw-bold">
                                {{ $index + 1 }}. {{ $unsur->kriteria }}
                                <span class="badge bg-light text-dark border ms-2">Bobot: {{ $unsur->bobot }}%</span>
                            </label>

                            <div class="input-group">
                            <input type="number" 
                                name="skor[{{ $unsur->id }}]" 
                                class="form-control fw-bold text-center"
                                value="{{ $existingNilai[$unsur->id] ?? '' }}" 
                                min="0" 
                                max="100" 
                                step="1"           {{-- Wajib langkah 1 (bulat) --}}
                                list="listNilai"   {{-- Menghubungkan ke Datalist di bawah --}}
                                placeholder="0-100"
                                required
                                {{-- Script ini mencegah user mengetik titik (.) atau koma (,) --}}
                                onkeypress="return event.charCode >= 48 && event.charCode <= 57" 
                                {{-- Script ini memastikan input tidak dipaste angka desimal --}}
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            >
                            <span class="input-group-text">%</span>
                        </div>
                            <small class="text-muted">
                                Berikan penilaian objektif untuk poin {{ strtolower($unsur->kriteria) }}.
                            </small>
                        </div>
                        @endforeach

                        <hr>

                        {{-- TOMBOL SIMPAN --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-lg {{ $contextRole == 'dosen_pembimbing' ? 'btn-success' : 'btn-primary' }}">
                                <i class="fas fa-save me-1"></i> Simpan Nilai
                            </button>
                        </div>

                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: SIDEBAR PANDUAN --}}
            <div class="col-md-4">
                <div class="card shadow-sm sticky-top" style="top: 20px; z-index: 1;">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-bold text-secondary">Panduan Penilaian</h6>
                    </div>
                    <div class="card-body small text-muted">
                        <p>Penilaian dilakukan berdasarkan kriteria berikut:</p>
                        <ul class="list-group list-group-flush">
                            {{-- List Panduan Dinamis sesuai Unsur --}}
                            @foreach($unsurList as $unsur)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>{{ $unsur->kriteria }}</span>
                                <span class="badge bg-secondary rounded-pill">{{ $unsur->bobot }}%</span>
                            </li>
                            @endforeach
                        </ul>
                        <div class="alert alert-info mt-3 mb-0 p-2">
                            <i class="fas fa-info-circle me-1"></i> Pastikan seluruh kolom terisi sebelum menyimpan.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <datalist id="listNilai">
    {{-- Loop otomatis angka 0 sampai 100 --}}
    @for ($i = 0; $i <= 100; $i++)
        <option value="{{ $i }}">
    @endfor
</datalist>
</div>
@endsection