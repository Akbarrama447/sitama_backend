@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 pb-5">
    {{-- Header & Tombol Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
        <a href="{{ route('sidang.index') }}" class="btn btn-outline-secondary btn-sm px-3 rounded-pill back-btn">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-0 fw-bold text-dark">Detail Nilai & Putusan Sidang</h4>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary">Detail Nilai & Putusan Sidang</h5>
        </div>
        <div class="card-body">
            {{-- Info Mahasiswa --}}
            <div class="row mb-3">
                <div class="col-md-2 fw-bold">NIM</div>
                <div class="col-md-10">: {{ $ta->mahasiswa->mhs_nim ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2 fw-bold">Nama Mahasiswa</div>
                <div class="col-md-10">: {{ $ta->mahasiswa->mhs_nama ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2 fw-bold">Judul TA</div>
                <div class="col-md-10">: {{ $ta->judul }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-2 fw-bold">Status Saat Ini</div>
                <div class="col-md-10">
                    : <span class="badge bg-info">{{ $sidang->status }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL NILAI PEMBIMBING --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light fw-bold">
            Detail Penilaian Pembimbing
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Nama Pembimbing</th>
                            <th>Unsur Penilaian</th>
                            <th width="10%" class="text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapPembimbing as $item)
                        <tr>
                            <td class="text-center">{{ $item['urutan'] }}</td>
                            <td>
                                <strong>{{ $item['dosen']->dosen_nama }}</strong><br>
                                <small class="text-muted">NIP: {{ $item['dosen']->dosen_nip }}</small>
                            </td>
                            <td>
                                <ul class="mb-0 ps-3 small">
                                    <li>Kedisiplinan: <strong>{{ $item['nilai']->nilai_kedisiplinan ?? '-' }}</strong></li>
                                    <li>Kreativitas: <strong>{{ $item['nilai']->nilai_kreativitas ?? '-' }}</strong></li>
                                    <li>Penguasaan Materi: <strong>{{ $item['nilai']->nilai_penguasaan_materi ?? '-' }}</strong></li>
                                    <li>Kelengkapan: <strong>{{ $item['nilai']->nilai_kelengkapan ?? '-' }}</strong></li>
                                </ul>
                            </td>
                            <td class="text-center align-middle fs-5 fw-bold text-primary">
                                {{-- Hitung Rata-rata sederhana (Opsional) --}}
                                @php
                                    $n = $item['nilai'];
                                    $total = $n ? ($n->nilai_kedisiplinan + $n->nilai_kreativitas + $n->nilai_penguasaan_materi + $n->nilai_kelengkapan) / 4 : 0;
                                @endphp
                                {{ number_format($total, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- TABEL NILAI PENGUJI --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light fw-bold">
            Detail Penilaian Penguji
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 5%">No</th>  <th style="width: 25%">Nama Penguji</th>
                            <th>Unsur Penilaian</th>
                            <th width="10%" class="text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapPenguji as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>

                            <td>
                                <strong>{{ $item['dosen']->dosen_nama }}</strong><br>
                                <small class="text-muted">NIP: {{ $item['dosen']->dosen_nip }}</small>
                                <br>
                                <span class="badge bg-secondary">{{ $item['peran'] }}</span>
                            </td>
                            <td>
                                <ul class="mb-0 ps-3 small">
                                    <li>Isi Naskah: <strong>{{ $item['nilai']->nilai_isi_naskah ?? '-' }}</strong></li>
                                    <li>Penguasaan Materi: <strong>{{ $item['nilai']->nilai_penguasaan_materi ?? '-' }}</strong></li>
                                    <li>Presentasi: <strong>{{ $item['nilai']->nilai_presentasi ?? '-' }}</strong></li>
                                    <li>Rancang Bangun: <strong>{{ $item['nilai']->nilai_hasil_rancang_bangun ?? '-' }}</strong></li>
                                </ul>
                            </td>
                            <td class="text-center align-middle fs-5 fw-bold text-primary">
                                @php
                                    $n = $item['nilai'];
                                    $total = $n ? ($n->nilai_isi_naskah + $n->nilai_penguasaan_materi + $n->nilai_presentasi + $n->nilai_hasil_rancang_bangun) / 4 : 0;
                                @endphp
                                {{ number_format($total, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- FORM PUTUSAN SIDANG --}}
    <div class="card shadow border-primary">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="fas fa-gavel me-2"></i> Putusan Sidang Akhir
        </div>
        <div class="card-body">
            <form action="{{ route('nilai.sekretaris.store', $sidang->id) }}" method="POST">
                @csrf
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nilai Akhir (Angka)</label>
                        <input type="number" step="0.01" name="nilai_akhir" class="form-control form-control-lg"
                               value="{{ old('nilai_akhir', $sidang->nilai_akhir) }}" required placeholder="Contoh: 85.50">
                        <small class="text-muted">Masukkan hasil perhitungan akhir.</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Status Kelulusan</label>
                        <select name="status_kelulusan" class="form-select form-select-lg" required>
                            <option value="Dijadwalkan" {{ $sidang->status == 'Dijadwalkan' ? 'selected' : '' }}>Belum Diputuskan (Dijadwalkan)</option>
                            <option value="Lulus" {{ $sidang->status == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="Lulus dengan revisi" {{ $sidang->status == 'Lulus dengan revisi' ? 'selected' : '' }}>Lulus dengan Revisi</option>
                            <option value="Tidak Lulus" {{ $sidang->status == 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100" onclick="return confirm('Apakah Anda yakin ingin menyimpan putusan ini?')">
                            <i class="fas fa-save me-1"></i> Simpan Putusan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection