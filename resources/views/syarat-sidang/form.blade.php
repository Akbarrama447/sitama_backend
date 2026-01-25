<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="tugas_akhir_id" class="form-label">{{ __('Tugas Akhir Id') }}</label>
            <input type="text" name="tugas_akhir_id" class="form-control @error('tugas_akhir_id') is-invalid @enderror" value="{{ old('tugas_akhir_id', $syaratSidang?->tugas_akhir_id) }}" id="tugas_akhir_id" placeholder="Tugas Akhir Id">
            {!! $errors->first('tugas_akhir_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="dokumen_id" class="form-label">{{ __('Dokumen Id') }}</label>
            <input type="text" name="dokumen_id" class="form-control @error('dokumen_id') is-invalid @enderror" value="{{ old('dokumen_id', $syaratSidang?->dokumen_id) }}" id="dokumen_id" placeholder="Dokumen Id">
            {!! $errors->first('dokumen_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="mhs_nim" class="form-label">{{ __('Mhs Nim') }}</label>
            <input type="text" name="mhs_nim" class="form-control @error('mhs_nim') is-invalid @enderror" value="{{ old('mhs_nim', $syaratSidang?->mhs_nim) }}" id="mhs_nim" placeholder="Mhs Nim">
            {!! $errors->first('mhs_nim', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="dokumen_file_original" class="form-label">{{ __('Dokumen File Original') }}</label>
            <input type="text" name="dokumen_file_original" class="form-control @error('dokumen_file_original') is-invalid @enderror" value="{{ old('dokumen_file_original', $syaratSidang?->dokumen_file_original) }}" id="dokumen_file_original" placeholder="Dokumen File Original">
            {!! $errors->first('dokumen_file_original', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="dokumen_file" class="form-label">{{ __('Dokumen File') }}</label>
            <input type="text" name="dokumen_file" class="form-control @error('dokumen_file') is-invalid @enderror" value="{{ old('dokumen_file', $syaratSidang?->dokumen_file) }}" id="dokumen_file" placeholder="Dokumen File">
            {!! $errors->first('dokumen_file', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="verified" class="form-label">{{ __('Verified') }}</label>
            <input type="text" name="verified" class="form-control @error('verified') is-invalid @enderror" value="{{ old('verified', $syaratSidang?->verified) }}" id="verified" placeholder="Verified">
            {!! $errors->first('verified', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="tanggal_upload" class="form-label">{{ __('Tanggal Upload') }}</label>
            <input type="text" name="tanggal_upload" class="form-control @error('tanggal_upload') is-invalid @enderror" value="{{ old('tanggal_upload', $syaratSidang?->tanggal_upload) }}" id="tanggal_upload" placeholder="Tanggal Upload">
            {!! $errors->first('tanggal_upload', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>