@extends('layouts.main')

@section('title', 'Mahasiswa Bimbingan')

@section('content')
    <h1 class="fw-bold mb-4">Daftar Mahasiswa Bimbingan</h1>

    @if ($bimbinganList->isEmpty())
        <div class="text-center text-lg text-muted">Belum ada mahasiswa bimbingan.</div>
    @else
        <div class="row g-4">
            @foreach ($bimbinganList as $bimbingan)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-lg p-4 bg-white/10 backdrop-blur-md rounded-3"
                         style="background: linear-gradient(160deg, rgba(255,255,255,0.15), rgba(95,167,255,0.3)); border: 1px solid rgba(255,255,255,0.2); transition: 0.3s;">

                        <h4 class="fw-semibold mb-2">{{ $bimbingan->mhs_nama }}</h4>
                        <p class="mb-1"><strong>Judul:</strong> {{ $bimbingan->tugas_judul }}</p>
                        <p class="mb-3"><strong>Urutan Pembimbing:</strong> {{ $bimbingan->urutan }}</p>
        <a href="#" class="active">Dashboard</a>


                        <form action="{{ route('bimbingan.approve', $bimbingan->id ?? 0) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                class="btn w-100 text-white fw-semibold py-2"
                                style="background: linear-gradient(90deg, #007BFF, #00C6FF); border: none; border-radius: 10px;
                                       box-shadow: 0 3px 8px rgba(0, 123, 255, 0.4); transition: all 0.3s ease;"
                                onmouseover="this.style.background='linear-gradient(90deg, #00C6FF, #007BFF)'"
                                onmouseout="this.style.background='linear-gradient(90deg, #007BFF, #00C6FF)'">
                                Approve
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
