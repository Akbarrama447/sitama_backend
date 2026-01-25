@extends('layouts.app')

@section('template_title')
    Bimbingans
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 text-uppercase">
                    <h4 class="m-0">{{ __('Bimbingans') }}</h4>
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
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Bimbingans') }}
                            </span>
                            </div>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success m-4">
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                        <div class="card-body bg-white">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="thead">
                                    <tr>
                                        <th>No</th>

                                        <th>Judul Tugas Akhir</th>
                                        <th>Dosen Pembimbing</th>

                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    ?>
                                    @foreach ($bimbingans as $bimbingan)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>
                                                <b>{{ $bimbingan->judul }}</b>
                                                <br>
                                                {{ $bimbingan->mahasiswa }}
                                            </td>
                                            <td>
                                                {!! $bimbingan->pembimbing !!}
                                            </td>

                                            <td>
                                                <form action="{{ route('ta-pembimbing.destroy', $bimbingan->id) }}"
                                                      method="POST">
                                                    <a class="btn btn-sm btn-success"
                                                       href="{{ route('ta-pembimbing.edit', $bimbingan->id) }}"><i
                                                            class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="event.preventDefault(); confirm('Are you sure to delete?') ? this.closest('form').submit() : false;">
                                                        <i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
