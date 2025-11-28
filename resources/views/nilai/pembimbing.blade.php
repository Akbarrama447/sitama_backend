@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('sidang.index') }}" class="btn btn-sm btn-secondary mb-2">← Kembali</a>
    <h4>Nilai Pembimbing - {{ $ta->mahasiswa->mhs_nama ?? $ta->mhs_nama }}</h4>
    <p><strong>Judul:</strong> {{ $ta->judul }}</p>

    <form action="{{ route('nilai.pembimbing.store', ['ta_id' => $ta->id, 'sidang_id' => $sidang->id]) }}" method="POST">
        @csrf
        @method('POST')
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Penilaian Pembimbing</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="kerajinan_nilai">Kerajinan (1-100)</label>
                            <input type="number" id="kerajinan_nilai" name="kerajinan_nilai" class="form-control" 
                                   value="{{ old('kerajinan_nilai', $nilai ? $nilai->kerajinan_nilai : '') }}" min="0" max="100">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="keteguhan_nilai">Keteguhan (1-100)</label>
                            <input type="number" id="keteguhan_nilai" name="keteguhan_nilai" class="form-control" 
                                   value="{{ old('keteguhan_nilai', $nilai ? $nilai->keteguhan_nilai : '') }}" min="0" max="100">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="kemajuan_nilai">Kemajuan (1-100)</label>
                            <input type="number" id="kemajuan_nilai" name="kemajuan_nilai" class="form-control" 
                                   value="{{ old('kemajuan_nilai', $nilai ? $nilai->kemajuan_nilai : '') }}" min="0" max="100">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="total_nilai">Total Nilai (1-100)</label>
                            <input type="number" id="total_nilai" name="total_nilai" class="form-control" 
                                   value="{{ old('total_nilai', $nilai ? $nilai->total_nilai : '') }}" min="0" max="100">
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