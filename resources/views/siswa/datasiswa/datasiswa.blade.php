@extends('layout.main')
@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Data Siswa</title>
        <style>
            
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <div class="d-flex justify-content-end align-items-center mb-2">
                                <div class="dropdown ms-2">
                                    <button class="btn btn-back dropdown-toggle mb-2" style="background-color: #7e7dfb; color: white;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Tambah Data
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                             {{-- <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus iduka ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Hapus</button>
                                            </form> --}}                                            
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#tambahSiswaModal">
                                                Tambah Data Manual
                                            </button>
                                            <button class="dropdown-item" type="button">
                                                Import Excel
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                
                            </div>
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-striped" style="text-align: center">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>NIS</th>
                                                <th>Kelas</th>
                                                <th>Aksi</th>
                                                <th>Status</th>
                                            </tr>
                                            <tr>
                                                <td>1.</td>
                                                <td>Malva Riski Nur Aulia</td>
                                                <td>222310275</td>
                                                <td>XII RPL 2</td>
                                                <td>
                                                    <a href="{{ route('detail.siswa')}}" class="btn btn-info px-3 py-2">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <form action="#" style="display:inline;">
                                                        <button type="submit" class="btn btn-danger px-3 py-2">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>    
                                                    </form>
                                                </td>                                                                                                
                                                <td></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    
      @include('siswa.datasiswa.createSiswa')
      @include('siswa.datasiswa.editSiswa')

    </html>

@endsection