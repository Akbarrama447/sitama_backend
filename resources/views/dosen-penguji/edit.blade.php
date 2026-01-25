@extends('layouts.app')

@section('template_title')
    {{ __('Ubah') }} Bimbingan
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 text-uppercase">
                    <h4 class="m-0">Ubah {{ __('Penguji') }}</h4>
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
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Ubah') }} Penguji</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('ta-penguji.update', $id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('dosen-penguji.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
