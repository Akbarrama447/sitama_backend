@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Bimbingan Mahasiswa</h3>
    
    {{-- Alert Messages --}}
    @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <table class="table table-bordered mt-3 table-striped">
        <thead class="table-dark">
            <tr>
                <th>Mahasiswa</th>
                <th>Judul Skripsi</th>
                <th>Tanggal & Catatan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bimbingan as $b)
            <tr>
                {{-- Nama Mahasiswa --}}
                <td>
                    <strong>{{ $b->mhs_nama }}</strong>
                </td>

                {{-- Judul TA --}}
                <td>
                    {{ $b->judul_ta }} <br>
                    <span class="badge bg-secondary">ID TA: {{ $b->ta_id }}</span>
                </td>

                {{-- Info Bimbingan --}}
                <td>
                    <small>{{ $b->tanggal }}</small><br>
                    {{ $b->catatan }}
                </td>

                {{-- Status Badge --}}
                <td>
                    @if($b->status == 2)
                        <span class="badge bg-success">✅ Verified</span>
                    @elseif($b->status == 1)
                        <span class="badge bg-danger">❌ Ditolak</span>
                    @else
                        <span class="badge bg-warning text-dark">⏳ Pending</span>
                    @endif
                </td>

                {{-- Tombol Aksi --}}
                <td>
                    @if($b->status == 2)
                        <button class="btn btn-success btn-sm" disabled>Sudah ACC</button>
                    @elseif($b->status == 1)
                        <button class="btn btn-danger btn-sm" disabled>Ditolak</button>
                    @else
                        <a href="{{ route('bimbingan.verify', $b->id) }}" 
                           class="btn btn-outline-success btn-sm"
                           onclick="return confirm('ACC bimbingan ini?')">Verify</a>
                        
                        <a href="{{ route('bimbingan.reject', $b->id) }}" 
                           class="btn btn-outline-danger btn-sm"
                           onclick="return confirm('Tolak bimbingan ini?')">Reject</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection