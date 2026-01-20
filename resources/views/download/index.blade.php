@extends('layouts.public')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-center">
                <h4><i class="fas fa-download text-primary"></i> Download sitama.apk</h4>
            </div>
            <div class="card-body text-center">

                <!-- Download untuk sitama.apk -->
                @if($apkExists)
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> File APK tersedia untuk diunduh
                    </div>

                    <div class="app-info mb-4">
                        <h5>Nama File: sitama.apk</h5>
                        <p><strong>Ukuran:</strong> {{ $apkSize }}</p>
                        <p><strong>Terakhir Dimodifikasi:</strong> {{ $apkLastModified }}</p>
                    </div>

                    <div class="download-section mb-5">
                        <a href="{{ route('download.apk') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-download"></i> Download sitama.apk
                        </a>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> File sitama.apk belum tersedia untuk diunduh
                    </div>
                @endif

                <div class="mt-4">
                    <p><strong>Catatan:</strong></p>
                    <ul class="text-left">
                        <li>Pastikan perangkat Anda mengizinkan instalasi dari sumber tidak dikenal</li>
                        <li>Aplikasi ini merupakan versi terbaru</li>
                        <li>Jika mengalami masalah saat download, coba refresh halaman</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection