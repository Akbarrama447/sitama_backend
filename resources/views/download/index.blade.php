@extends('layouts.public')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-center">
                <h4><i class="fas fa-download text-primary"></i> Download Aplikasi Sitama</h4>
            </div>
            <div class="card-body text-center">
                @if($fileExists)
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Aplikasi tersedia untuk diunduh
                    </div>

                    <div class="app-info mb-4">
                        <h5>Nama File: {{ $fileName }}</h5>
                        <p><strong>Ukuran:</strong> {{ $fileSize }}</p>
                        <p><strong>Terakhir Dimodifikasi:</strong> {{ $lastModified }}</p>
                    </div>

                    <div class="download-section">
                        <a href="{{ route('download.app') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-download"></i> Download Aplikasi
                        </a>
                    </div>

                    <div class="mt-4">
                        <p><strong>Catatan:</strong></p>
                        <ul class="text-left">
                            <li>Pastikan perangkat Anda mengizinkan instalasi dari sumber tidak dikenal</li>
                            <li>Aplikasi ini merupakan versi terbaru</li>
                            <li>Jika mengalami masalah saat download, coba refresh halaman</li>
                        </ul>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Aplikasi belum tersedia untuk diunduh
                    </div>
                    <p>Maaf, aplikasi Flutter belum tersedia untuk diunduh saat ini.</p>
                    <p>Silakan hubungi administrator untuk informasi lebih lanjut.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection