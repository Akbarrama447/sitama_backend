@extends('layouts.app')

@section('template_title')
    {{ __('Buat') }} Prodi Dosen
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 text-uppercase">
                    <h4 class="m-0">Tambah {{ __('Prodi Dosens') }}</h4>
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
                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Buat') }} Prodi Dosen</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('prodi-dosen.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('prodi-dosen.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
