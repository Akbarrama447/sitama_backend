@extends('layouts.app')

@section('content')
<div class="container-fluid pt-1 pb-5">
    {{-- Header & Tombol Kembali --}}
    <div class="container-fluid justify-content-between align-items-center mb-4 mt-3">
        <a href="{{ route('sidang.index') }}" class="btn btn-outline-secondary btn-sm px-3 rounded-pill back-btn">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>

        <div class="container-fluid justify-content-between align-items-center mb-4 mt-3">
        <h4 class="mb-1 fw-bold text-dark">Rekapitulasi Nilai Sidang</h4>
</div>
    </div>

    <div class="container-fluid justify-content-between align-items-center mb-4 mt-3">

    {{-- Info Mahasiswa --}}
    <div class="card border-0 shadow-sm mb-4" style="border-left: 5px solid #0d6efd;">
        <div class="card-body py-4">
            <div class="d-flex align-items-center">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                    <i class="fas fa-user-graduate text-primary fs-3"></i>
                </div>
                <div class="ms-3">
                    <h5 class="fw-bold mb-1">{{ $sidang->tugasAkhir->mahasiswa->nama ?? $sidang->tugasAkhir->mahasiswa->mhs_nama ?? 'Mahasiswa' }}</h5>
                    <div class="text-muted small">
                        <span class="me-3"><i class="fas fa-id-card me-1"></i> NIM: {{ $sidang->tugasAkhir->mahasiswa->nim ?? $sidang->tugasAkhir->mahasiswa->mhs_nim ?? '-' }}</span>
                        <span><i class="fas fa-book me-1"></i> {{ $sidang->tugasAkhir->judul ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- ================= TABEL PEMBIMBING ================= --}}
        <div class="col-lg-12 mb-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold text-success">
                        <i class="fas fa-chalkboard-teacher me-2"></i>Penilaian Pembimbing
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="bg-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="ps-4 py-3" width="30%">Dosen Pembimbing</th>
                                    <th class="py-3" width="30%">Kriteria Penilaian</th>
                                    <th class="text-center py-3" width="10%">Skor</th>
                                    <th class="text-center py-3" width="10%">Bobot</th>
                                    <th class="text-end pe-4 py-3" width="20%">Total (NxB)</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @php
                                    $groupedPembimbing = $nilaiPembimbing->groupBy('dosen_nip');
                                    $grandTotalPembimbing = 0;
                                    $countPembimbing = $groupedPembimbing->count();
                                @endphp

                                @forelse($groupedPembimbing as $nip => $scores)
                                    @php
                                        $subTotalDosen = 0;
                                        // Ambil Nama Dosen dari data pertama
                                        $namaDosen = $scores->first()->dosen->dosen_nama ?? $scores->first()->dosen->nama ?? 'Nama Tidak Ditemukan';
                                    @endphp

                                    @foreach($scores as $index => $item)
                                        @php
                                            $scoreHitung = ($item->nilai * $item->unsur->bobot) / 100;
                                            $subTotalDosen += $scoreHitung;
                                        @endphp
                                        <tr>
                                            {{-- Kolom Nama Dosen (Digabung ke bawah / Rowspan) --}}
                                            @if($index === 0)
                                                <td rowspan="{{ $scores->count() + 1 }}" class="ps-4 align-top py-4 border-end bg-light bg-opacity-10">
                                                    <div class="fw-bold text-dark mb-1">{{ $namaDosen }}</div>
                                                    <div class="small text-muted mb-2"><i class="fas fa-id-badge me-1"></i>{{ $nip }}</div>
                                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">
                                                        Pembimbing {{ $loop->parent->iteration }}
                                                    </span>
                                                </td>
                                            @endif

                                            <td class="py-2 text-secondary">{{ $item->unsur->nama_unsur }}</td>
                                            <td class="text-center fw-bold text-dark">{{ $item->nilai }}</td>
                                            <td class="text-center text-muted small">{{ $item->unsur->bobot }}%</td>
                                            <td class="text-end pe-4 text-secondary">{{ number_format($scoreHitung, 2) }}</td>
                                        </tr>
                                    @endforeach

                                    {{-- Subtotal per Dosen --}}
                                    <tr class="bg-success bg-opacity-10 border-top">
                                        <td colspan="3" class="text-end text-success fw-bold small py-3">Total Nilai Pembimbing {{ $loop->iteration }}</td>
                                        <td class="text-end pe-4 fw-bold text-success fs-6 py-3">{{ number_format($subTotalDosen, 2) }}</td>
                                    </tr>
                                    @php $grandTotalPembimbing += $subTotalDosen; @endphp

                                @empty
                                    <tr><td colspan="5" class="text-center py-5 text-muted fst-italic">Belum ada penilaian pembimbing.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Footer Rata-rata Pembimbing --}}
                @if($countPembimbing > 0)
                <div class="card-footer bg-white border-top py-3">
                    <div class="d-flex justify-content-between align-items-center px-3">
                        <span class="text-muted small text-uppercase fw-bold letter-spacing-1">Rata-rata Pembimbing</span>
                        <span class="fs-5 fw-bold text-dark">{{ number_format($grandTotalPembimbing / $countPembimbing, 2) }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- ================= TABEL PENGUJI ================= --}}
        <div class="col-lg-12 mb-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-user-edit me-2"></i>Penilaian Penguji
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="bg-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="ps-4 py-3" width="30%">Dosen Penguji</th>
                                    <th class="py-3" width="30%">Kriteria Penilaian</th>
                                    <th class="text-center py-3" width="10%">Skor</th>
                                    <th class="text-center py-3" width="10%">Bobot</th>
                                    <th class="text-end pe-4 py-3" width="20%">Total (NxB)</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @php
                                    $groupedPenguji = $nilaiPenguji->groupBy('dosen_nip');
                                    $grandTotalPenguji = 0;
                                    $countPenguji = $groupedPenguji->count();
                                @endphp

                                @forelse($groupedPenguji as $nip => $scores)
                                    @php
                                        $subTotalDosen = 0;
                                        $namaDosen = $scores->first()->dosen->dosen_nama ?? $scores->first()->dosen->nama ?? 'Nama Tidak Ditemukan';
                                    @endphp

                                    @foreach($scores as $index => $item)
                                        @php
                                            $scoreHitung = ($item->nilai * $item->unsur->bobot) / 100;
                                            $subTotalDosen += $scoreHitung;
                                        @endphp
                                        <tr>
                                            @if($index === 0)
                                                <td rowspan="{{ $scores->count() + 1 }}" class="ps-4 align-top py-4 border-end bg-light bg-opacity-10">
                                                    <div class="fw-bold text-dark mb-1">{{ $namaDosen }}</div>
                                                    <div class="small text-muted mb-2"><i class="fas fa-id-badge me-1"></i>{{ $nip }}</div>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                                                        Penguji {{ $loop->parent->iteration }}
                                                    </span>
                                                </td>
                                            @endif

                                            <td class="py-2 text-secondary">{{ $item->unsur->nama_unsur }}</td>
                                            <td class="text-center fw-bold text-dark">{{ $item->nilai }}</td>
                                            <td class="text-center text-muted small">{{ $item->unsur->bobot }}%</td>
                                            <td class="text-end pe-4 text-secondary">{{ number_format($scoreHitung, 2) }}</td>
                                        </tr>
                                    @endforeach

                                    <tr class="bg-primary bg-opacity-10 border-top">
                                        <td colspan="3" class="text-end text-primary fw-bold small py-3">Total Nilai Penguji {{ $loop->iteration }}</td>
                                        <td class="text-end pe-4 fw-bold text-primary fs-6 py-3">{{ number_format($subTotalDosen, 2) }}</td>
                                    </tr>
                                    @php $grandTotalPenguji += $subTotalDosen; @endphp

                                @empty
                                    <tr><td colspan="5" class="text-center py-5 text-muted fst-italic">Belum ada penilaian penguji.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($countPenguji > 0)
                <div class="card-footer bg-white border-top py-3">
                    <div class="d-flex justify-content-between align-items-center px-3">
                        <span class="text-muted small text-uppercase fw-bold letter-spacing-1">Rata-rata Penguji</span>
                        <span class="fs-5 fw-bold text-dark">{{ number_format($grandTotalPenguji / $countPenguji, 2) }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ================= FORM KEPUTUSAN ================= --}}
    @if($countPembimbing > 0 && $countPenguji > 0)
    <div class="card border-0 shadow-sm mt-2 border-top border-warning border-3">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-gavel me-2 text-warning"></i>Keputusan Sidang
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('sidang.storeSekretaris', $sidang->id) }}" method="POST">
                @csrf
                <div class="row justify-content-center align-items-end">

                    {{-- Nilai Akhir (Auto) --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Nilai Akhir (Auto)</label>
                        <div class="input-group">
                            <input type="text" class="form-control fw-bold fs-5 text-center bg-light text-primary"
                                   value="{{ $sidang->nilai_akhir ?? 0 }}" readonly>
                            <span class="input-group-text bg-light border-start-0"><i class="fas fa-calculator text-muted"></i></span>
                        </div>
                    </div>

                    {{-- Status Kelulusan --}}
                    <div class="col-md-5 mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Status Kelulusan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fas fa-certificate text-warning"></i></span>
                            <select name="status_kelulusan" class="form-select fs-5" required>
                                <option value="" disabled selected>-- Pilih Keputusan --</option>
                                <option value="1" {{ $sidang->status == '1' ? 'selected' : '' }}>Lulus</option>
                                <option value="2" {{ $sidang->status == '2' ? 'selected' : '' }}>Lulus dengan Revisi</option>
                                <option value="3" {{ $sidang->status == '3' ? 'selected' : '' }}>Revisi / Mengulang</option>
                                <option value="4" {{ $sidang->status == '4' ? 'selected' : '' }}>Tidak Lulus</option>
                            </select>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="col-md-3 mb-3">
                        <button type="submit" class="btn btn-warning w-100 fw-bold text-dark py-2 shadow-sm">
                            <i class="fas fa-save me-1"></i> Simpan Status
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection