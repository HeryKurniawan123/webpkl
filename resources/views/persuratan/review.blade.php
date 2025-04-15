@extends('layout.main')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Review Pengajuan</title>
    <style>
        .card-hover {
            transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
            height: 70px;
            flex-direction: column;
            justify-content: center;
            display: flex;
        }

        .card-hover:hover {
            transform: scale(1.03);
            background-color: #7e7dfb !important;
            color: white !important;
        }

        .card-hover:hover .btn-hover {
            background-color: white;
            color: #7e7dfb;
            border-color: white;
        }

        .btn-hover {
            background-color: #7e7dfb;
            color: white;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            border-radius: 50px;
            border: 2px solid #7e7dfb;
        }

        .btn-hover:hover {
            background-color: white;
            color: #7e7dfb;
            border-color: white;
        }

        .dropdown-btn {
            color: #7e7dfb;
            font-size: 25px;
            border-radius: 50px;
        }

        .card-hover:hover .dropdown-btn {
            color: white !important;
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
                <div class="row">
                    <div class="card mb-3">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Review Pengajuan Institusi / Perusahaan</h5>

                            <div class="d-flex gap-2">
                                <a href="{{ route('review.pengajuanditerima') }}" class="btn btn-success btn-status btn-sm">
                                    <i class="bi bi-check-circle"></i>
                                    <span class="d-none d-md-inline">History Diterima</span>
                                </a>
                                <a href="{{ route('review.pengajuanditolak') }}" class="btn btn-danger btn-status btn-sm">
                                    <i class="bi bi-x-circle"></i>
                                    <span class="d-none d-md-inline">History Ditolak</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">

                        {{-- Jika tidak ada pengajuan --}}
                        @if($pengajuanUsulans->isEmpty())
                        <p class="text-center">Tidak ada pengajuan yang tersedia.</p>
                        @else

                        {{-- Looping Data Pengajuan --}}
                        @foreach($pengajuanUsulans as $iduka_id => $pengajuanGroup)
                        <div class="card mb-3 shadow-sm card-hover" style="padding: 30px; border-radius: 10px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="mb-0" style="font-size: 18px"><strong>{{ $pengajuanGroup->first()->iduka->nama }}</strong></div>
                                    <small class="text-muted">{{ $pengajuanGroup->count() }} siswa mengajukan ke sini</small>
                                </div>
                                <div>
                                    <a href="{{ route('kaprog.review.detailUsulanPkl', ['iduka_id' => $iduka_id]) }}" class="btn btn-hover rounded-pill">Detail</a>
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

    @include('iduka.dataiduka.createiduka')
</body>

</html>

@endsection