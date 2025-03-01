@extends('layout.main')
@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Iduka</title>
    <style>
        .table td {
            vertical-align: middle;
        }

        .table td:first-child {
            width: 40%;
            text-align: left;
        }

        .table td:nth-child(2) {
            width: 1%;
            text-align: right;
        }

        .table td:last-child {
            width: 55%;
            text-align: left;
        }

        .card-header {
            max-width: 100%;
            padding: 25px 20px 10px 20px;
            border-radius: 8px 8px 0 0;
        }

        .btn-back {
            background-color: #7e7dfb;
            color: white;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out, background-color 0.2s ease-in-out;
        }

        .btn-back:hover {
            background-color: #7e7dfb;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.25);
        }

        .btn-back:active {
            color: white;
            background-color: #6b6bfa !important;
            transform: translateY(3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="card-header" style="background-color: #7e7dfb">
                        <h5 style="color: white;">DETAIL IDUKA - {{ $iduka->nama }}</h5>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-end mt-0 mb-2">
                                <button type="button" class="btn btn-danger gap-2 me-2" data-bs-toggle="modal" data-bs-target="#tambahIdukaModal">
                                    <i class="bi bi-filetype-pdf"></i>
                                </button>
                                <button type="button" class="btn btn-back shadow-sm" data-bs-toggle="modal" data-bs-target="#editIdukaModal">
                                    Edit Data
                                </button>
                            </div>
                            <table class="table table-striped">
                                <tr>
                                    <td><i class="bi bi-building"></i> Nama IDUKA</td>
                                    <td>:</td>
                                    <td>{{ $iduka->nama }}</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-building"></i> Nama Pimpinan</td>
                                    <td>:</td>
                                    <td>{{ $iduka->nama_pimpinan ?? '-'}}</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-building"></i> NIP/NIK Pimpinan</td>
                                    <td>:</td>
                                    <td>{{ $iduka->nip_pimpinan ?? '-'}}</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-building"></i> Jabatan</td>
                                    <td>:</td>
                                    <td>{{ $iduka->jabatan?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-geo-alt"></i> Alamat Lengkap</td>
                                    <td>:</td>
                                    <td>{{ $iduka->alamat }}</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-geo-alt"></i> Kode Pos</td>
                                    <td> : </td>
                                    <td>{{ $iduka->kode_pos }}</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-telephone"></i> Nomor Telepon</td>
                                    <td>:</td>
                                    <td>{{ $iduka->telepon }}</td>
                                </tr>

                                <tr>
                                    <td><i class="bi bi-envelope"></i> Email</td>
                                    <td>:</td>
                                    <td>{{ $iduka->email }}</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-lock"></i> Password</td>
                                    <td>:</td>
                                    <td>******</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-briefcase"></i> Bidang Industri</td>
                                    <td>:</td>
                                    <td>{{ $iduka->bidang_industri }}</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-handshake"></i> Kerjasama</td>
                                    <td>:</td>
                                    <td>{{ $iduka->kerjasama }}</td>
                                </tr>
                                <tr>
                                    <td><i class="bi bi-people"></i> Jumlah Kuota PKL</td>
                                    <td>:</td>
                                    <td>{{ $iduka->kuota_pkl }}</td>
                                </tr>

                            </table>
                            <div class="col-lg-12 d-flex justify-content-between mt-4">
                                <a href="{{ route('data.iduka')}}" class="btn btn-back shadow-sm">
                                    Kembali
                                </a>
                                @if(auth()->user()->role == 'siswa')
                                <form action="{{ route('pengajuan.ajukan', $iduka->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary shadow-sm">Ajukan PKL</button>
                                </form>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('iduka.dataiduka.editiduka')
</body>

</html>

@endsection