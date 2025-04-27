@extends('layout.main')
@section('content')

<style>
    .card-hover {
        transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .card-hover:hover {
        transform: scale(1.03);
        background-color: #7e7dfb !important;
        color: white !important;
    }
    .btn-hover {
        background-color: #7e7dfb;
        color: white;
        border: 2px solid #7e7dfb;
        border-radius: 50px;
        padding: 5px 15px;
        transition: background-color 0.3s, color 0.3s;
    }
    .btn-hover:hover {
        background-color: white;
        color: #7e7dfb;
    }
    .btn-status {
        padding: 10px 20px;
        border-radius: 4px;
    }
    @media (max-width: 767px) {
        .btn-status {
            flex: 1;
            margin: 5px 0;
        }
    }
</style>

<div class="container-fluid">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="mb-4">Review Formulir Usulan INSTITUSI</h4>

        {{-- Alert Success/Error --}}
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Card Action --}}
        <div class="card mb-3">
            <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="mb-3 mb-md-0">Aksi Review</h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('review.historyditerima') }}" class="btn btn-success btn-status btn-sm">
                        <i class="bi bi-check-circle"></i> <span class="d-none d-md-inline">History Diterima</span>
                    </a>
                    <a href="{{ route('review.historyditolak') }}" class="btn btn-danger btn-status btn-sm">
                        <i class="bi bi-x-circle"></i> <span class="d-none d-md-inline">History Ditolak</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Daftar Usulan INSTITUSI --}}
        <div class="row">
            <div class="col-md-12">
                @forelse($usulanIdukas as $usulan)
                    <div class="card mb-3 shadow-sm card-hover">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><strong>{{ $usulan->user->name }}</strong></h6>
                                <small>Kelas: {{ $usulan->user->dataPribadi->kelas->name_kelas ?? '-' }}</small>
                            </div>
                            <div>
                                <a href="{{ route('kaprog.review.detail', ['id' => $usulan->id]) }}" class="btn btn-hover rounded-pill">Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada usulan INSTITUSI.</p>
                @endforelse
            </div>
        </div>

        {{-- Bagian Pengajuan PKL (jika ada) --}}
        @if(isset($pengajuanUsulans) && !$pengajuanUsulans->isEmpty())
            <hr>
            <div class="row">
                <div class="col-md-12">
                    @foreach($pengajuanUsulans as $iduka_id => $pengajuanGroup)
                        <div class="card mb-3 shadow-sm card-hover">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><strong>{{ $pengajuanGroup->first()->iduka->nama }}</strong></h6>
                                    <small class="text-muted">{{ $pengajuanGroup->count() }} siswa mengajukan ke sini</small>
                                </div>
                                <div>
                                    <a href="{{ route('kaprog.review.detailUsulanPkl', ['iduka_id' => $iduka_id]) }}" class="btn btn-hover rounded-pill">Detail</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>

@endsection
