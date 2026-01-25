@extends('layouts.app')

@section('template_title')
    Syarat Sidangs
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 text-uppercase">
                    <h4 class="m-0">{{ __('Syarat Sidangs') }}</h4>
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
                                {{ __('Syarat Sidangs') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('ta-approval.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Tambah') }}  {{ __('Syarat Sidangs') }}
                                </a>
                              </div>
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

									<th >Tugas Akhir Id</th>
									<th >Dokumen Id</th>
									<th >Mhs Nim</th>
									<th >Dokumen File Original</th>
									<th >Dokumen File</th>
									<th >Verified</th>
									<th >Tanggal Upload</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($syaratSidangs as $syaratSidang)
                                        <tr>
                                            <td>{{ ++$i }}</td>

										<td >{{ $syaratSidang->tugas_akhir_id }}</td>
										<td >{{ $syaratSidang->dokumen_id }}</td>
										<td >{{ $syaratSidang->mhs_nim }}</td>
										<td >{{ $syaratSidang->dokumen_file_original }}</td>
										<td >{{ $syaratSidang->dokumen_file }}</td>
										<td >{{ $syaratSidang->verified }}</td>
										<td >{{ $syaratSidang->tanggal_upload }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-success" href="{{ route('ta-approval.edit', $syaratSidang->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $syaratSidangs->withQueryString()->links() !!}
            </div>
        </div>
    </div>
    </div>
@endsection
