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
                            <div class="d-flex justify-content-between align-items-center mb-2">
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
                                                    <a href="#" class="btn btn-warning px-3 py-2" data-bs-toggle="modal" data-bs-target="#tambahSiswaModal">
                                                        <i class="bi bi-pen"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-info px-3 py-2" data-bs-toggle="modal" data-bs-target="#detailSiswaModal">
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

    {{-- create datasiswa --}}
    <div class="modal fade" id="tambahSiswaModal" tabindex="-1" aria-labelledby="tambahSiswaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="tambahSiswaModalLabel">Form Tambah Data Siswa</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="" class="form-label">Nama Siswa</label>
                    <input type="text" class="form-control" id="" name="" placeholder="Masukkan Nama Siswa" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">NIS</label>
                    <input type="text" class="form-control" id="" name="" placeholder="Masukkan NIS" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Email</label>
                    <input type="email" class="form-control" id="" name="" placeholder="Masukkan Email" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input type="text" class="form-control" id="" name="" placeholder="Masukkan Password" required>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>


      {{-- edit data Siswa --}}
      <div class="modal fade" id="editSiswaModal" tabindex="-1" aria-labelledby="editSiswaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="editSiswaModalLabel">Form Edit Data Siswa</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="" class="form-label">Nama Siswa</label>
                    <input type="text" class="form-control" id="" name="" placeholder="Masukkan Nama Siswa" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">NIS</label>
                    <input type="text" class="form-control" id="" name="" placeholder="Masukkan NIS" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Email</label>
                    <input type="email" class="form-control" id="" name="" placeholder="Masukkan Email" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input type="text" class="form-control" id="" name="" placeholder="Masukkan Password" required>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>

      @include('siswa.detailSiswa')

    </html>

@endsection