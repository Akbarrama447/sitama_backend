@extends('layouts.app')

@section('template_title')
    {{ $syaratSidang->name ?? __('Show') . " " . __('Syarat Sidang') }}
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 text-uppercase">
                    <h4 class="m-0">Detail {{ __('Syarat Sidang') }}</h4>
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
                            <span class="card-title">{{ __('Show') }} Syarat Sidang</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('ta-approval.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">

                                <div class="form-group mb-2 mb20">
                                    <strong>Tugas Akhir Id:</strong>
                                    {{ $syaratSidang->tugas_akhir_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Dokumen Id:</strong>
                                    {{ $syaratSidang->dokumen_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Mhs Nim:</strong>
                                    {{ $syaratSidang->mhs_nim }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Dokumen File Original:</strong>
                                    {{ $syaratSidang->dokumen_file_original }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Dokumen File:</strong>
                                    {{ $syaratSidang->dokumen_file }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Verified:</strong>
                                    {{ $syaratSidang->verified }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Tanggal Upload:</strong>
                                    {{ $syaratSidang->tanggal_upload }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
