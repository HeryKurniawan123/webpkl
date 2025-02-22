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
                                    <button class="btn btn-back dropdown-toggle mb-2"
                                        style="background-color: #7e7dfb; color: white;" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Tambah Data
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            {{-- <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus iduka ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Hapus</button>
                                            </form> --}}
                                            <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                data-bs-target="#tambahSiswaModal">
                                                Tambah Data Manual
                                            </button>
                                            <button class="dropdown-item" type="button">
                                                <form action="{{ route('siswa.import') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="file" name="file" class="d-none" id="fileInput"
                                                        required onchange="this.form.submit()">
                                                    <button type="button" class="dropdown-item"
                                                        onclick="document.getElementById('fileInput').click();">
                                                        Import Excel
                                                    </button>
                                                </form>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <table class="table table-hover">

                                        <table class="table table-bordered">
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
                                                        </td>
                                                    </tr>
                                                    {{-- Modal Edit Siswa --}}
                                                    <div class="modal fade" id="editSiswaModal{{ $s->id }}"
                                                        tabindex="-1" aria-labelledby="editSiswaModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit Data Siswa</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <form action="{{ route('siswa.update', $s->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Nama Siswa</label>
                                                                            <input type="text" class="form-control"
                                                                                name="name" value="{{ $s->name }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">NIS</label>
                                                                            <input type="text" class="form-control"
                                                                                name="nip" value="{{ $s->nip }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Kelas</label>
                                                                            <select class="form-control" name="kelas_id"
                                                                                required>
                                                                                <option value="">Pilih Kelas</option>
                                                                                @foreach ($kelas as $kls)
                                                                                    <option value="{{ $kls->id }}"
                                                                                        {{ $s->kelas_id == $kls->id ? 'selected' : '' }}>
                                                                                        {{ $kls->kelas }}
                                                                                        {{ $kls->name_kelas }}  
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label"> Konsentrasi
                                                                                Keahlian</label>
                                                                            <select class="form-control" name="konke_id"
                                                                                required>
                                                                                <option value="">Pilih Konsentrasi
                                                                                    Keahlian</option>
                                                                                @foreach ($konke as $k)
                                                                                    <option value="{{ $k->id }}"
                                                                                        {{ $s->konke_id == $k->id ? 'selected' : '' }}>
                                                                                        {{ $k->name_konke }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Email</label>
                                                                            <input type="text" class="form-control"
                                                                                name="email" value="{{ $s->email }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Password Baru
                                                                                (Opsional)</label>
                                                                            <input type="password" class="form-control"
                                                                                name="password">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Simpan
                                                                            Perubahan</button>
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
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama Siswa" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="mb-3">
                            <label class="form-label">NIS</label>
                            <input type="text" class="form-control" name="nip" value="{{ old('nip') }}" placeholder="Masukkan NISN" required>
                            @error('nip')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select class="form-control" name="kelas_id" required>
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $kls)
                                    <option value="{{ $kls->id }}" {{ old('kelas_id') == $kls->id ? 'selected' : '' }}>
                                        {{ $kls->kelas }} {{ $kls->name_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="mb-3">
                            <label class="form-label">Konsentrasi Keahlian</label>
                            <select class="form-control" name="konke_id" required>
                                <option value="">Pilih Konsentrasi Keahlian</option>
                                @foreach ($konke as $k)
                                    <option value="{{ $k->id }}" {{ old('konke_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->name_konke }}
                                    </option>
                                @endforeach
                            </select>
                            @error('konke_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Masukkan Email" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Masukkan Password" required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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