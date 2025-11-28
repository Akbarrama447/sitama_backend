
@extends('layouts.app')
@section('content')
<div class="container">
    <a href="{{ route('bimbingan.index') }}" class="btn btn-sm btn-secondary mb-2">← Kembali</a>
    <h4>Detail Bimbingan - {{ $ta->mahasiswa->nama ?? $ta->mhs_nama }} <small class="text-muted">({{ $peran ?? 'Peran: -' }})</small></h4>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Catatan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($list as $item)
            <tr>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->catatan }}</td>
                <td>
                    @if($item->status == 2) <span class="badge bg-success">Sudah ACC</span>
                    @elseif($item->status == 1) <span class="badge bg-danger">Ditolak</span>
                    @else <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </td>
                <td>
                    @if($isPembimbing)
                        @if($item->status == 0) <!-- Pending status -->
                            <!-- Single button with dropdown for pending status -->
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Aksi
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <form action="{{ route('bimbingan.verify', $item->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            <button class="dropdown-item text-success" type="submit" onclick="return confirm(' bimbingan ini?')">Verify</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('bimbingan.reject', $item->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            <button class="dropdown-item text-danger" type="submit" onclick="return confirm('Tolak bimbingan ini?')">Reject</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @elseif($item->status == 1) <!-- Rejected status -->
                            <form action="{{ route('bimbingan.verify', $item->id) }}" method="POST" style="display:inline">
                                @csrf
                                <button class="btn btn-sm btn-warning text-dark" onclick="return confirm('Setujui bimbingan ini?')">Verifikasi</button>
                            </form>
                        @else <!-- Verified status (status == 2) -->
                            <button class="btn btn-sm btn-success" disabled>Verified</button>
                        @endif
                    @else
                        <button class="btn btn-sm btn-secondary" disabled>Tidak berwenang</button>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection