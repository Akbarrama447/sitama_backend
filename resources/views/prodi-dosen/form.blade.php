<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="prodi_id" class="form-label">{{ __('Prodi Id') }}</label>
            <input type="text" name="prodi_id" class="form-control @error('prodi_id') is-invalid @enderror" value="{{ old('prodi_id', $prodiDosen?->prodi_id) }}" id="prodi_id" placeholder="Prodi Id">
            {!! $errors->first('prodi_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="dosen_nip" class="form-label">{{ __('Dosen Nip') }}</label>
            <input type="text" name="dosen_nip" class="form-control @error('dosen_nip') is-invalid @enderror" value="{{ old('dosen_nip', $prodiDosen?->dosen_nip) }}" id="dosen_nip" placeholder="Dosen Nip">
            {!! $errors->first('dosen_nip', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>