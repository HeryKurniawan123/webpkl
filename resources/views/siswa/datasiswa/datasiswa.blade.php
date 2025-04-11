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
            @media (max-width: 768px) {
                .table th:nth-child(2),
                .table td:nth-child(2) {
                    min-width: 180px; 
                    max-width: 100%; 
                    white-space: normal; 
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                }
                .table th:nth-child(5), 
                .table td:nth-child(5) {
                    min-width: 180px; 
                    max-width: 100%;
                    white-space: normal; 
                    word-wrap: break-word;
                    overflow-wrap: break-word;
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
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">Data Siswa</h5>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-warning btn-sm d-flex align-items-center"
                                            data-bs-toggle="modal" data-bs-target="#searchModal">
                                            <i class="bi bi-search"></i>
                                            <span class="d-none d-md-inline ms-1">Search</span>
                                        </button>
                                
                                        <div class="dropdown">
                                            <button class="btn btn-sm dropdown-toggle d-flex align-items-center"
                                                style="background-color: #7e7dfb; color: white;"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-plus-lg"></i>
                                                <span class="d-none d-md-inline ms-1">Tambah Data</span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
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
                                </div>                                
                            </div>
                        </div>

                        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="searchModalLabel">Cari Data Siswa</h5>
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
                        <div class="card">
                            <div class="card-body">
                                @if(session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif   
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead style="text-align: center">
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
                                        <tbody style="text-align: center">
                                            @foreach ($siswa as $index => $s)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $s->name }}</td>
                                                    <td>{{ $s->nip }}</td>
                                                    <td>{{ optional($s->kelas)->kelas ?? '-' }} {{ optional($s->kelas)->name_kelas ?? '-' }}</td>
                                                    <td>{{ optional($s->konke)->name_konke ?? '-' }}</td>
                                                    <td></td>
                                                    <td>
                                                        <div class="d-flex gap-1 justify-content-center flex-nowrap">
                                                            <button class="btn btn-warning btn-sm d-flex align-items-center"
                                                                data-bs-toggle="modal" data-bs-target="#editSiswaModal{{ $s->id }}">
                                                                <i class="bi bi-pen"></i>
                                                            </button>
                                                            <a href="{{ route('siswa.detail', $s->id) }}" class="btn btn-info btn-sm d-flex align-items-center">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center">
                                                                    <i class="bi bi-trash3"></i>
                                                                </button>
                                                            </form>
                                                        </div>
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
                                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                                                    <button type="button" class="btn btn-primary btn-sm">Simpan</button>
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
    

    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah aksi default tombol

                Swal.fire({
                    title: "Apakah kamu yakin?",
                    text: "Data ini tidak bisa dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Temukan form terdekat dan submit
                        this.closest('form').submit();
                    }
                });
            });
        });


    </script>

    @include('siswa.datasiswa.createSiswa')
    @include('siswa.datasiswa.editSiswa')

    </html>
    <script>
         document.addEventListener("DOMContentLoaded", function () {
        // Ambil data dari session flash Laravel melalui input hidden
        let successMessage = document.getElementById("success-message")?.value;
        let errorMessage = document.getElementById("error-message")?.value;

        if (successMessage) {
            Swal.fire({
                icon: "success",
                title: "Sukses!",
                text: successMessage,
                showConfirmButton: false,
                timer: 3000
            });
        }

        if (errorMessage) {
            Swal.fire({
                icon: "error",
                title: "Gagal!",
                text: errorMessage,
                showConfirmButton: true
            });
        }
    });
    
            document.querySelectorAll('.delete-btn').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                title: "Apakah kamu yakin?",
                text: "Data ini tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });


    document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.querySelector("input[name='search']");
    const tableRows = document.querySelectorAll("tbody tr");

    searchInput.addEventListener("keyup", function() {
        const searchValue = this.value.toLowerCase();

        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? "" : "none";
        });
    });
});



</script>
@endsection