@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Header & Tombol Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
        <a href="{{ route('sidang.index') }}" class="btn btn-outline-secondary btn-sm px-3 rounded-pill back-btn">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-0 fw-bold text-dark">Nilai Pembimbing</h4>
    </div>

    <h4>Nilai Pembimbing - {{ $ta->mahasiswa->mhs_nama ?? $ta->mhs_nama }}</h4>
    <p>
        <strong>Judul:</strong> {{ $ta->judul }} <br>
        <strong>Peran Anda:</strong> <span class="badge bg-success">Pembimbing</span>
    </p>

    <form action="{{ route('nilai.pembimbing.store', ['ta_id' => $ta->id, 'sidang_id' => $sidang->id]) }}" method="POST">
        @csrf
        @method('POST')

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Form Penilaian Pembimbing</h5>
                    </div>
                    <div class="card-body">
                        {{-- Error Validation Alert --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- 1. Kedisiplinan --}}
                        <div class="form-group mb-3">
                            <label for="nilai_kedisiplinan" class="form-label fw-bold">1. Kedisiplinan dalam Bimbingan (0-100)</label>
                            <input type="number" id="nilai_kedisiplinan" name="nilai_kedisiplinan" class="form-control"
                                   placeholder="Masukkan nilai..."
                                   value="{{ old('nilai_kedisiplinan', $nilai ? $nilai->nilai_kedisiplinan : '') }}"
                                   min="0" max="100" required>
                            <small class="text-muted">Menilai ketepatan waktu, frekuensi kehadiran, dan sikap selama proses bimbingan.</small>
                        </div>

                        {{-- 2. Kreativitas --}}
                        <div class="form-group mb-3">
                            <label for="nilai_kreativitas" class="form-label fw-bold">2. Kreativitas Pemecahan Masalah (0-100)</label>
                            <input type="number" id="nilai_kreativitas" name="nilai_kreativitas" class="form-control"
                                   placeholder="Masukkan nilai..."
                                   value="{{ old('nilai_kreativitas', $nilai ? $nilai->nilai_kreativitas : '') }}"
                                   min="0" max="100" required>
                            <small class="text-muted">Menilai kemampuan mahasiswa dalam memberikan solusi inovatif terhadap masalah TA.</small>
                        </div>

                        {{-- 3. Penguasaan Materi --}}
                        <div class="form-group mb-3">
                            <label for="nilai_penguasaan_materi" class="form-label fw-bold">3. Penguasaan Materi (0-100)</label>
                            <input type="number" id="nilai_penguasaan_materi" name="nilai_penguasaan_materi" class="form-control"
                                   placeholder="Masukkan nilai..."
                                   value="{{ old('nilai_penguasaan_materi', $nilai ? $nilai->nilai_penguasaan_materi : '') }}"
                                   min="0" max="100" required>
                            <small class="text-muted">Menilai kedalaman pemahaman mahasiswa terhadap topik yang dikerjakan.</small>
                        </div>

                        {{-- 4. Kelengkapan --}}
                        <div class="form-group mb-3">
                            <label for="nilai_kelengkapan" class="form-label fw-bold">4. Kelengkapan dan Referensi (0-100)</label>
                            <input type="number" id="nilai_kelengkapan" name="nilai_kelengkapan" class="form-control"
                                   placeholder="Masukkan nilai..."
                                   value="{{ old('nilai_kelengkapan', $nilai ? $nilai->nilai_kelengkapan : '') }}"
                                   min="0" max="100" required>
                            <small class="text-muted">Menilai kelengkapan dokumen laporan, source code, dan kualitas referensi/pustaka.</small>
                        </div>

                        <hr>



                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save me-1"></i> Simpan Nilai Pembimbing
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi Panduan --}}
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Panduan Penilaian Pembimbing</h6>
                    </div>
                    <div class="card-body small">
                        <p>Penilaian didasarkan pada proses bimbingan selama satu semester.</p>
                        <ul>
                            <li><strong>Kedisiplinan:</strong> Konsistensi bimbingan dan attitude.</li>
                            <li><strong>Kreativitas:</strong> Kemandirian dalam mencari solusi.</li>
                            <li><strong>Materi:</strong> Pemahaman teknis dan teoritis.</li>
                            <li><strong>Kelengkapan:</strong> Dokumen TA sesuai standar penulisan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection