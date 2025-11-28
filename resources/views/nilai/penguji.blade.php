@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('sidang.index') }}" class="btn btn-sm btn-secondary mb-2">← Kembali</a>
    <h4>Nilai Penguji - {{ $ta->mahasiswa->mhs_nama ?? $ta->mhs_nama }}</h4>
    <p><strong>Judul:</strong> {{ $ta->judul }}</p>

    <form action="{{ route('nilai.penguji.store', ['ta_id' => $ta->id, 'sidang_id' => $sidang->id]) }}" method="POST">
        @csrf
        @method('POST')
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Penilaian Penguji</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="nilai_ta">Nilai Tugas Akhir (1-100)</label>
                            <input type="number" id="nilai_ta" name="nilai_ta" class="form-control" 
                                   value="{{ old('nilai_ta', $nilai ? $nilai->nilai : '') }}" min="0" max="100">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="catatan">Catatan</label>
                            <textarea id="catatan" name="catatan" class="form-control">{{ old('catatan', $nilai ? $nilai->catatan : '') }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection