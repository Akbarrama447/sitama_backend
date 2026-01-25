@extends('layouts.app')

@section('template_title')
    {{ __('Buat') }} Syarat Sidang
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 text-uppercase">
                    <h4 class="m-0">Tambah {{ __('Syarat Sidangs') }}</h4>
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
                        <span class="card-title">{{ __('Buat') }} Syarat Sidang</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('ta-approval.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('syarat-sidang.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
