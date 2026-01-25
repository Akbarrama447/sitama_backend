@extends('layouts.app')

@section('template_title')
    {{ $bimbingan->name ?? __('Show') . " " . __('Bimbingan') }}
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 text-uppercase">
                    <h4 class="m-0">Detail {{ __('Bimbingan') }}</h4>
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
                            <span class="card-title">{{ __('Show') }} Bimbingan</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('ta-pembimbing.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Tugas Akhir Id:</strong>
                                    {{ $bimbingan->tugas_akhir_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Dosen Nip:</strong>
                                    {{ $bimbingan->dosen_nip }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Urutan:</strong>
                                    {{ $bimbingan->urutan }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
