@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Header & Tombol Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
        <a href="{{ route('sidang.index') }}" class="btn btn-outline-secondary btn-sm px-3 rounded-pill back-btn">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-0 fw-bold text-dark">Nilai Penguji</h4>
    </div>

    <h4>Nilai Penguji - {{ $ta->mahasiswa->mhs_nama ?? $ta->mhs_nama }}</h4>
    <p>
        <strong>Judul:</strong> {{ $ta->judul }} <br>
        <strong>Peran Anda:</strong> <span class="badge bg-info">{{ $dosenPenguji->peran }}</span>
    </p>

    <form action="{{ route('nilai.penguji.store', ['ta_id' => $ta->id, 'sidang_id' => $sidang->id]) }}" method="POST">
        @csrf
        @method('POST')

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Form Penilaian Penguji</h5>
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

                        {{-- 1. Isi dan Bobot Naskah --}}
                        <div class="form-group mb-3">
                            <label for="nilai_isi_naskah" class="form-label fw-bold">1. Isi dan Bobot Naskah (0-100)</label>
                            <input type="number" id="nilai_isi_naskah" name="nilai_isi_naskah" class="form-control"
                                   placeholder="Masukkan nilai..."
                                   value="{{ old('nilai_isi_naskah', $nilai ? $nilai->nilai_isi_naskah : '') }}"
                                   min="0" max="100" required>
                            <small class="text-muted">Menilai kedalaman analisis, relevansi teori, dan bobot permasalahan.</small>
                        </div>

                        {{-- 2. Penguasaan Materi --}}
                        <div class="form-group mb-3">
                            <label for="nilai_penguasaan_materi" class="form-label fw-bold">2. Penguasaan Materi (0-100)</label>
                            <input type="number" id="nilai_penguasaan_materi" name="nilai_penguasaan_materi" class="form-control"
                                   placeholder="Masukkan nilai..."
                                   value="{{ old('nilai_penguasaan_materi', $nilai ? $nilai->nilai_penguasaan_materi : '') }}"
                                   min="0" max="100" required>
                            <small class="text-muted">Menilai kemampuan menjawab pertanyaan dan pemahaman konsep.</small>
                        </div>

                        {{-- 3. Presentasi dan Penampilan --}}
                        <div class="form-group mb-3">
                            <label for="nilai_presentasi" class="form-label fw-bold">3. Presentasi dan Penampilan (0-100)</label>
                            <input type="number" id="nilai_presentasi" name="nilai_presentasi" class="form-control"
                                   placeholder="Masukkan nilai..."
                                   value="{{ old('nilai_presentasi', $nilai ? $nilai->nilai_presentasi : '') }}"
                                   min="0" max="100" required>
                            <small class="text-muted">Menilai kejelasan penyampaian, slide presentasi, dan sikap.</small>
                        </div>

                        {{-- 4. Hasil Rancang Bangun --}}
                        <div class="form-group mb-3">
                            <label for="nilai_hasil_rancang_bangun" class="form-label fw-bold">4. Hasil Rancang Bangun (0-100)</label>
                            <input type="number" id="nilai_hasil_rancang_bangun" name="nilai_hasil_rancang_bangun" class="form-control"
                                   placeholder="Masukkan nilai..."
                                   value="{{ old('nilai_hasil_rancang_bangun', $nilai ? $nilai->nilai_hasil_rancang_bangun : '') }}"
                                   min="0" max="100" required>
                            <small class="text-muted">Menilai fungsionalitas produk/aplikasi dan kesesuaian dengan tujuan.</small>
                        </div>

                        <hr>

                        {{-- Catatan --}}
                        <div class="form-group mb-3">
                            <label for="catatan" class="form-label fw-bold">Catatan / Revisi (Opsional)</label>
                            <textarea id="catatan" name="catatan" class="form-control" rows="4" placeholder="Tuliskan catatan revisi untuk mahasiswa...">{{ old('catatan', $nilai ? $nilai->catatan : '') }}</textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-1"></i> Simpan Nilai
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi Bobot (Opsional - Bisa dihapus kalau tidak perlu) --}}
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Panduan Penilaian</h6>
                    </div>
                    <div class="card-body small">
                        <p>Mohon berikan penilaian secara objektif berdasarkan kinerja mahasiswa saat sidang.</p>
                        <ul>
                            <li><strong>Isi Naskah:</strong> Kesesuaian format, tata tulis, dan substansi.</li>
                            <li><strong>Penguasaan:</strong> Kemampuan mempertahankan argumen.</li>
                            <li><strong>Presentasi:</strong> Komunikasi dan manajemen waktu.</li>
                            <li><strong>Produk:</strong> Demo aplikasi/alat berjalan lancar.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection