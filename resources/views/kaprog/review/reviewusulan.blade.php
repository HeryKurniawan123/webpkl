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
        .btn-status {
            width: auto; 
            padding: 10px 20px; 
            border-radius: 4px; 
         }
                        
        @media (max-width: 767px) {
            .button-group {
                display: flex;
                flex-direction: row; 
                justify-content: space-between;
            }
            .btn-status {
                flex: 1; 
                margin: 5px 0; 
            }
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

                            <div class="d-flex gap-2">
                            <a href="{{ route('review.historyditerima') }}" class="btn btn-success btn-status btn-sm">
                                <i class="bi bi-check-circle"></i>
                                    <span class="d-none d-md-inline">History Diterima</span>
                            </a>
                            <a href="{{ route('review.historyditolak') }}" class="btn btn-danger btn-status btn-sm">
                                <i class="bi bi-x-circle"></i>
                                    <span class="d-none d-md-inline">History Ditolak</span>
                            </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">

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

                        <h4 class="mb-4">Review Ajuan Usulan IDUKA</h4>
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
</body>

</html>
@endsection