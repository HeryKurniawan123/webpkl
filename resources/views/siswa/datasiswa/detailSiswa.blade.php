@extends('layout.main')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Detail Data Nama Siswa</title>
        <style>
            .nav-tabs .nav-link.active {
                background-color: #9f9fff6c;
            }

            .nav-tabs .nav-link {
                background-color: white;
                color: white;
                border: 1px solid #white;

            }

            .nav-tabs .nav-link:hover {
                background-color: 9f9fff;
                color: white;
            }

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
                        <div class="col-md-12 mt-3">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="data-pribadi-tab" data-bs-toggle="tab"
                                                href="#dataPribadi" role="tab">
                                                Data Pribadi
                                            </a>
                                        </li>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="data-orangtua-tab" data-bs-toggle="tab"
                                                href="#dataOrangTua" role="tab">
                                                Data Orang Tua
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="dropdown">
                                        <button class="btn btn-back dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown">
                                            Edit Data
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button class="btn " data-bs-toggle="modal"
                                                    data-bs-target="#editSiswaModal{{ $siswa->id }}">
                                                    Edit Data Pribadi
                                                </button>
                                                <button class="btn " data-bs-toggle="modal"
                                                    data-bs-target="#editOrtuModal{{ $siswa->id }}">
                                                    Edit Data Orangg Tua
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="dataPribadi" role="tabpanel">
                                            <h4>Data Pribadi</h4>

                                            <table class="table table-striped">
                                                <tr>
                                                    <td>Nama Siswa</td>
                                                    <td>:</td>
                                                    <td>{{ $siswa->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>NIS</td>
                                                    <td>:</td>
                                                    <td>{{ $siswa->nip }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Konsentrasi Keahlian</td>
                                                    <td>:</td>
                                                    <td>{{ optional($siswa->dataPribadi)->konsentrasi_keahlian ?? '-' }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Kelas</td>
                                                    <td>:</td>
                                                    <td>{{ $siswa->kelas }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td>:</td>
                                                    <td>{{ $siswa->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Password</td>
                                                    <td>:</td>
                                                    <td>******</td>
                                                </tr>

                                            </table>
                                        </div>

                                        <div class="tab-pane fade" id="dataOrangTua" role="tabpanel">
                                            <h5>Data Orang Tua</h5>
                                            @if ($siswa->dataPribadi)
                                                <table class="table table-striped">
                                                    <tr>
                                                        <td>Nama Ayah</td>
                                                        <td>:</td>
                                                        <td>{{ $siswa->dataPribadi->name_ayh ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nama Ibu</td>
                                                        <td>:</td>
                                                        <td>{{ $siswa->dataPribadi->name_ibu ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>NIK</td>
                                                        <td>:</td>
                                                        <td>{{ $siswa->dataPribadi->nik ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alamat</td>
                                                        <td>:</td>
                                                        <td>{{ $siswa->dataPribadi->alamat ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email </td>
                                                        <td>:</td>
                                                        <td>{{ $siswa->dataPribadi->email_ortu ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>No Telepon</td>
                                                        <td>:</td>
                                                        <td>{{ $siswa->dataPribadi->no_tlp ?? '-' }}</td>
                                                    </tr>

                                                </table>
                                            @else
                                                <p><em>Data pribadi belum diisi oleh siswa.</em></p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content mt-3 mb-2">
                                        <a href="{{ route('siswa.index') }}" class="btn btn-back shadow-sm">
                                            Kembali
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('siswa.datasiswa.editSiswa')
        @include('orangtua.dataOrtu.editOrtu')
    </body>
    <div class="modal fade" id="editSiswaModal{{ $siswa->id }}" tabindex="-1" aria-labelledby="editSiswaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Siswa</label>
                            <input type="text" class="form-control" name="name" value="{{ $siswa->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIS</label>
                            <input type="text" class="form-control" name="nip" value="{{ $siswa->nip }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konsentrasi Keahlian</label>
                            <input type="text" class="form-control" name="konsentrasi_keahlian"
                                value="{{ optional($siswa->dataPribadi)->konsentrasi_keahlian }}" >
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <input type="text" class="form-control" name="kelas" value="{{ $siswa->kelas }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" value="{{ $siswa->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password Baru
                                (Opsional)
                            </label>
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editOrtuModal{{ $siswa->id }}" tabindex="-1" aria-labelledby="editOrtuModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Orang Tua</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                @if ($siswa->dataPribadi)
                    <form action="{{ route('siswa.data_pribadi.update', $siswa->dataPribadi->id) }}" method="POST">
                    @else
                        <form action="#" method="POST">
                @endif

                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Ayah</label>
                        <input type="text" class="form-control" name="name_ayh"
                            value="{{ optional($siswa->dataPribadi)->name_ayh }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Ibu</label>
                        <input type="text" class="form-control" name="name_ibu"
                            value="{{ optional($siswa->dataPribadi)->name_ibu }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nik"
                            value="{{ optional($siswa->dataPribadi)->nik }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat"
                            value="{{ optional($siswa->dataPribadi)->alamat }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="email_ortu"
                            value="{{ optional($siswa->dataPribadi)->email_ortu }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telepon</label>
                        <input type="text" class="form-control" name="no_tlp"
                            value="{{ optional($siswa->dataPribadi)->no_tlp }}" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan
                        Perubahan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    </html>
@endsection
