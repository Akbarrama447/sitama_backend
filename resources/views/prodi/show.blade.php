@extends('layouts.app')

@section('template_title')
    {{ $prodi->name ?? __('Show') . " " . __('Prodi') }}
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 text-uppercase">
                    <h4 class="m-0">Detail {{ __('Prodi') }}</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Prodi</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('prodi.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Jurusan Id:</strong>
                                    {{ $prodi->jurusan_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Nama Prodi:</strong>
                                    {{ $prodi->nama_prodi }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
