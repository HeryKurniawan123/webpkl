@extends('layout.main')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Review Usulan IDUKA</title>
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

        .button-group {
            margin-bottom: 18px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="mb-4">Review Formulir Usulan IDUKA</h4>

                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="button-group">
                            <a href="{{ route('review.historyditerima') }}" class="btn btn-success btn-status">History Diterima</a>
                            <a href="{{ route('review.historyditolak') }}" class="btn btn-danger btn-status">History Ditolak</a>
                        </div>

                        @foreach($usulanIdukas as $usulan)
                        <div class="card mb-3 shadow-sm card-hover" style="padding: 30px; border-radius: 10px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="mb-0" style="font-size: 18px"><strong>{{ $usulan->user->name }}</strong></div>
                                    <div class="">Kelas: {{ $usulan->user->dataPribadi->kelas->name_kelas ?? '-' }}</div>
                                </div>
                                <div class="d-flex align-items-center">
                                <a href="{{ route('kaprog.review.detail', ['id' => $usulan->id]) }}" class="btn btn-hover rounded-pill">Detail</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @if($usulanIdukas->isEmpty())
                        <p class="text-muted">Belum ada usulan IDUKA.</p>
                        @endif


                        {{-- Bagian Pengajuan PKL (jika diperlukan) --}}
                        @if(isset($pengajuanUsulans) && !$pengajuanUsulans->isEmpty())
                        <hr>
                        <h4 class="mb-4">Review Pengajuan Usulan IDUKA</h4>
                        @foreach($pengajuanUsulans as $pengajuan)
                        <div class="card-hover">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0"><strong>{{ $pengajuan->user->name }}</strong></h5>
                                    <p class="mb-0">Institusi: {{ $pengajuan->iduka->nama ?? '-' }}</p>
                                    <p class="mb-0">Status: {{ ucfirst($pengajuan->status) }}</p>
                                </div>
                                <div>
                                <a href="{{ route('kaprog.review.detailUsulanPkl', ['iduka_id' => $pengajuan->iduka_id]) }}" class="btn btn-hover rounded-pill">Detail</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
@endsection