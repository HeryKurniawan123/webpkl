@extends('layout.main')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Data Siswa Kelas XII RPL 2</title>
        <style>
            /* .btn-back {
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
            } */
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                                    <div class="d-md-flex d-block">
                                        <h5 class="mb-0">Data Siswa </h5>
                                        <h5 class="mb-0 d-md-inline d-block">XII RPL 2</h5>
                                    </div>
                                    <div class="d-flex gap-2 ms-auto">
                                        <!-- Tombol Kembali -->
                                        <a href="{{ route('kelas.index')}}" class="btn btn-primary btn-back btn-sm shadow-sm">
                                            <i class="bi bi-arrow-left-circle"></i>
                                            <span class="d-none d-md-inline">Kembali</span>
                                        </a>
                                
                                        <!-- Tombol Search -->
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#searchModal">
                                            <i class="bi bi-search"></i>
                                            <span class="d-none d-md-inline">Search</span>
                                        </button>
                                
                                        <!-- Dropdown Tambah -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-plus-lg"></i> <span class="d-none d-md-inline">Tambah</span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#tambahSiswaModal">
                                                        Tambah Data Manual
                                                    </button>
                                                    <button class="dropdown-item" type="button">
                                                        <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="file" name="file" class="d-none" id="fileInput" required onchange="this.form.submit()">
                                                            <button type="button" class="dropdown-item" onclick="document.getElementById('fileInput').click();">
                                                                Import Excel
                                                            </button>
                                                        </form>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>                                                                                               
                            </div>
                        
                            <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="searchModalLabel">Cari Siswa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="#">
                                                <input type="text" name="search" class="form-control" placeholder="Cari Siswa...">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>                        
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover" style="text-align: center">
                                            <thead>
                                                <tr>

                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>NIS</th>
                                                    <th>Kelas</th>
                                                    <th>Konsentrasi Keahlian</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($siswa as $index => $s)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $s->name }}</td>
                                                        <td>{{ $s->nip }}</td>
                                                        <td>{{ optional($s->kelas)->name_kelas ?? '-' }}</td>
                                                        <td>{{ optional($s->konke)->name_konke ?? '-' }}</td>
                                                        <td></td>
                                                        <td>
                                                            <div class="d-flex gap-1 justify-content-center flex-nowrap">
                                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                                    data-bs-target="#editSiswaModal{{ $s->id }}">
                                                                    <i class="bi bi-pen"></i>
                                                                </button>
                                                                <a href="{{ route('siswa.detail', $s->id) }}"
                                                                    class="btn btn-info btn-sm">
                                                                    <i class="bi bi-eye"></i>
                                                                </a>
                                                                <form action="{{ route('siswa.destroy', $s->id) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Yakin ingin menghapus siswa ini?')">
                                                                        <i class="bi bi-trash3"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
            
                                                    <!-- Modal Edit Siswa untuk setiap siswa -->
                                                    <div class="modal fade" id="editSiswaModal{{ $s->id }}" tabindex="-1" aria-labelledby="editSiswaModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit Data Siswa</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <form action="{{ route('siswa.update', $s->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Nama Siswa</label>
                                                                            <input type="text" class="form-control" name="name" value="{{ $s->name }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">NIS</label>
                                                                            <input type="text" class="form-control" name="nip" value="{{ $s->nip }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Kelas</label>
                                                                            <select class="form-control" name="kelas_id" required>
                                                                                <option value="">Pilih Kelas</option>
                                                                                @foreach ($kelas as $kls)
                                                                                    <option value="{{ $kls->id }}" {{ $s->kelas_id == $kls->id ? 'selected' : '' }}>
                                                                                        {{ $kls->kelas }} {{ $kls->name_kelas }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label"> Konsentrasi Keahlian</label>
                                                                            <select class="form-control" name="konke_id" required>
                                                                                <option value="">Pilih Konsentrasi Keahlian</option>
                                                                                @foreach ($konke as $k)
                                                                                    <option value="{{ $k->id }}" {{ $s->konke_id == $k->id ? 'selected' : '' }}>
                                                                                        {{ $k->name_konke }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Email</label>
                                                                            <input type="text" class="form-control" name="email" value="{{ $s->email }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Password Baru (Opsional)</label>
                                                                            <input type="password" class="form-control" name="password">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </tbody>
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
    <div class="modal fade" id="tambahSiswaModal" tabindex="-1" aria-labelledby="tambahSiswaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('siswa.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Siswa</label>
                            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Siswa"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIS</label>
                            <input type="text" class="form-control" name="nip" placeholder="Masukkan NISN"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <input type="text" class="form-control" value="{{ $s->kelas->kelas }} {{ optional($s->kelas)->name_kelas ?? '-' }}" readonly>
                            <input type="hidden" name="kelas_id" value="{{ $s->kelas_id }}">
                        </div>
                        
                        
                        <div class="mb-3">
                            <label class="form-label">Konsentrasi Keahlian</label>
                            <select class="form-control" name="konke_id" required>
                                <option value="">Pilih Konsentrasi Keahlian</option>
                                @foreach ($konke as $k)
                                    <option value="{{ $k->id }}">{{ $k->name_konke }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Masukkan Email"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Masukkan Password"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                        <button type="submit" class="btn btn-primary">Simpan</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('siswa.datasiswa.createSiswa')
    @include('siswa.datasiswa.editSiswa')

    </html>
@endsection
