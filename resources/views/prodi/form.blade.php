<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="jurusan_id" class="form-label">{{ __('Jurusan Id') }}</label>
            <input type="text" name="jurusan_id" class="form-control @error('jurusan_id') is-invalid @enderror" value="{{ old('jurusan_id', $prodi?->jurusan_id) }}" id="jurusan_id" placeholder="Jurusan Id">
            {!! $errors->first('jurusan_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="nama_prodi" class="form-label">{{ __('Nama Prodi') }}</label>
            <input type="text" name="nama_prodi" class="form-control @error('nama_prodi') is-invalid @enderror" value="{{ old('nama_prodi', $prodi?->nama_prodi) }}" id="nama_prodi" placeholder="Nama Prodi">
            {!! $errors->first('nama_prodi', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>