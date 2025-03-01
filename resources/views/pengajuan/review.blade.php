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
                <h4 class="mb-4">Review Pengajuan IDUKA</h4>

                <div class="button-group">
                    <a href="{{ route('review.pengajuanditerima') }}" class="btn btn-success btn-status">History Diterima</a>
                    <a href="{{ route('review.pengajuanditolak') }}" class="btn btn-danger btn-status">History Ditolak</a>
                </div>


                <div class="row">
                    <div class="col-md-12 mt-3">

                        {{-- Jika tidak ada pengajuan --}}
                        @if($pengajuans->isEmpty())
                        <p class="text-center">Tidak ada pengajuan yang tersedia.</p>
                        @else

                        {{-- Looping Data Pengajuan --}}
                        @foreach($pengajuans as $pengajuan)
                        <div class="card mb-3 shadow-sm card-hover" style="padding: 30px; border-radius: 10px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="mb-0" style="font-size: 18px">
                                        <strong>{{ $pengajuan->dataPribadi->user->name ?? 'Nama Tidak Tersedia' }}</strong>
                                    </div>
                                    <div class="">
                                        Kelas: {{ $pengajuan->dataPribadi->kelas->name_kelas ?? '-' }}
                                    </div>
                                </div>

                                <div class="d-flex align-items-center">
                                    {{-- Tombol Detail --}}
                                    <a href="{{ route('pengajuan.detail', $pengajuan->id) }}" class="btn btn-info">
                                        Lihat Detail
                                    </a>

                                    {{-- Dropdown Menu --}}
                                    <div class="dropdown ms-2">
                                        <button class="btn dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            ⋮
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">Hapus</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
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