@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4">
    <h3 class="mt-1 mb-2">Data Ujian Sidang Tugas Akhir</h3>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0" style="font-size: 0.85rem;">
                    <thead class="bg-light text-center">
                        <tr>
                            <th width="3%">No</th>
                            <th width="22%">Judul</th>
                            <th width="20%">Mahasiswa & Jadwal</th>
                            <th width="18%">Pembimbing</th>
                            <th width="18%">Penguji</th>
                            <th width="8%">Status</th>
                            <th width="5%">Nilai</th>
                            <th width="6%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sidangs as $s)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + $sidangs->firstItem() - 1 }}</td>

                            <td>
                                <div class="fw-bold text-uppercase mb-2">
                                    {{ $s->tugasAkhir->judul ?? '-' }}
                                </div>
                                <span class="badge bg-danger">
                                    <i class="fas fa-file-pdf me-1"></i> Naskah Laporan
                                </span>
                            </td>

                            <td>
                                <div class="fw-bold text-uppercase">{{ $s->tugasAkhir->mahasiswa->mhs_nama ?? 'Nama Tidak Ada' }}</div>
                                <div class="fw-bold mb-2">({{ $s->tugasAkhir->mahasiswa->mhs_nim ?? '-' }})</div>
                                <div class="border-top my-2"></div>
                                <div class="text-muted" style="font-size: 0.8rem;">
                                    <strong>Hari/Tgl:</strong> {{ $s->info_jadwal['hari_tgl'] }} <br>
                                    <strong>Ruangan:</strong> {{ $s->info_jadwal['ruangan'] }} <br>
                                    <strong>Waktu:</strong> {{ $s->info_jadwal['waktu'] }} <br>
                                    <strong>Sesi:</strong> {{ $s->info_jadwal['sesi'] }}
                                </div>
                            </td>

                            <td>
                                <ol class="ps-3 mb-3">
                                    @forelse($s->tugasAkhir->bimbingan as $b)
                                        <li class="mb-2">
                                            <div class="fw-bold">{{ $b->dosen->dosen_nama ?? 'Nama Tidak Ditemukan' }}</div>
                                            <small class="text-muted" style="font-size: 0.75rem;">NIP: {{ $b->dosen_nip }}</small>
                                            <div class="mt-1"><span class="badge bg-light text-dark border">Pembimbing {{ $b->urutan }}</span></div>
                                        </li>
                                    @empty
                                        <li class="text-muted">-</li>
                                    @endforelse
                                </ol>

                                <div class="border-top pt-2 mt-2">
                                    <small class="text-muted fw-bold d-block mb-1">Sekretaris:</small>
                                    @if($s->sekretaris)
                                        <div class="fw-bold">{{ $s->sekretaris->dosen_nama }}</div>
                                        <small class="text-muted" style="font-size: 0.75rem;">NIP: {{ $s->sekretaris_nip }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <ol class="ps-3 mb-0">
                                    @forelse($s->dosenPengujis as $p)
                                        <li class="mb-2">
                                            <div class="fw-bold">{{ $p->dosen_nama ?? 'Nama Tidak Ditemukan' }}</div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">NIP: {{ $p->dosen_nip }}</small>
                                            @if($p->pivot->peran)
                                                <span class="badge bg-light text-dark border mt-1">Penguji {{ $p->pivot->peran }}</span>
                                            @endif
                                        </li>
                                    @empty
                                        <li class="text-muted">-</li>
                                    @endforelse
                                </ol>
                            </td>

                            <td class="text-center">
                                <span class="badge bg-{{ $s->badge_color }}">{{ match($s->status) {
                                    '0' => 'Terjadwal',
                                    '1' => 'Lulus',
                                    '2' => 'Lulus dengan Revisi',
                                    '3' => 'Revisi',
                                    '4' => 'Tidak Lulus',
                                    default => $s->status
                                }
                                }}
                            </span>
                            </td>

                            <td class="text-center fw-bold fs-6">
                                {{ $s->nilai_akhir ?? 0 }}
                            </td>

                            <td class="text-center">
                                @if($s->peran_user !== 'Tidak Ada')
                                    <a href="{{ route('nilai.show', $s->id) }}" class="btn btn-outline-primary btn-sm w-100 mb-1" title="Input Nilai">
                                        <i class="fas fa-pencil-alt"></i> Nilai
                                    </a>

                                    @if($s->peran_user == 'Sekretaris')
                                        <div class="badge bg-warning text-dark w-100">Sekretaris</div>
                                    @else
                                        <div class="small text-muted fw-bold">{{ $s->peran_user }}</div>
                                    @endif
                                @else
                                    <button class="btn btn-light btn-sm w-100 text-muted" disabled><i class="fas fa-lock"></i></button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">Belum ada data sidang.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end p-3">
                {{ $sidangs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection