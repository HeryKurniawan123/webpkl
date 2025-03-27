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
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            border-radius: 50px;
            padding: 5px 12px;
            font-size: 25px;
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
                <h4 class="mb-4">Review Usulan IDUKA</h4>

                <div class="row">
                    @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif   
                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="col-md-12 mt-3">
                        <div class="button-group">
                           
                            <a href="{{ route('review.historyditerima') }}" class="btn btn-success btn-status">History Diterima</a>
                            <a href="{{ route('review.historyditolak') }}" class="btn btn-danger btn-status">History Ditolak</a>
                           
                        </div>

                        {{-- **Bagian Usulan IDUKA** --}}
                       
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

                        {{-- **Bagian Pengajuan PKL** --}}
                      
                        @foreach($pengajuanUsulans as $pengajuan)
                        <div class="card mb-3 shadow-sm card-hover" style="padding: 30px; border-radius: 10px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="mb-0" style="font-size: 18px"><strong>{{ $pengajuan->user->name }}</strong></div>
                                    <div class="">Kelas: {{ $pengajuan->user->dataPribadi->kelas->name_kelas ?? '-' }}</div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('kaprog.review.detailUsulan', ['id' => $pengajuan->id]) }}" class="btn btn-hover rounded-pill">Detail</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('iduka.dataiduka.createiduka')
</body>

</html>
@endsection
