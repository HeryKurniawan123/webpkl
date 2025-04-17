@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">          
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">Data Guru</h5>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#searchModal">
                                    <i class="bi bi-search"></i>
                                    <span class="d-none d-md-inline">Search</span>
                                </button>
                
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahGuruModal">
                                    <i class="bi bi-plus-lg"></i> <span class="d-none d-md-inline">Tambah</span>
                                </button>
                            </div>
                        </div>
                    </div>
                
                    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="searchModalLabel">Cari Guru</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="#">
                                        <input type="text" name="search" class="form-control" placeholder="Cari Guru...">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
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
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif   
                        <div class="table-responsive">
                            <table class="table table-hover" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th style="min-width: 300px;">Nama Guru</th>
                                        <th>NIK</th>
                                        <th>NIP/NUPTK</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($guru as $g)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $g->nama }}</td>
                                        <td>{{ $g->nik }}</td>
                                        <td>{{ $g->nip }}</td>
                                        <td>{{ $g->email }}</td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center flex-nowrap">
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editGuruModal{{ $g->id }}">
                                                    <i class="bi bi-pen"></i>
                                                </button>
                                                <form action="{{ route('guru.destroy', $g->id) }}" method="POST" class="delete-form d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete-btn btn btn-danger btn-sm">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </form>                                                
                                            </div>

                                        </td>
                                    </tr>
    
                                    {{-- Modal Edit --}}
                                    <div class="modal fade" id="editGuruModal{{ $g->id }}" tabindex="-1" aria-labelledby="editGuruModalLabel{{ $g->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="editGuruModalLabel{{ $g->id }}">Form Edit Data Guru</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('guru.update', $g->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Guru*</label>
                                                            <input type="text" class="form-control" name="nama" value="{{ $g->nama }}" required>
                                                            <small class="form-text text-muted"><i>Nama lengkap ini akan tercatat di sistem, pastikan sudah benar!</i></small>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">NIK*</label>
                                                            <input type="text" class="form-control" name="nik" value="{{ $g->nik }}" required>
                                                            <small class="form-text text-muted"><i>Isi NIK di sini, pastikan sesuai dengan data di KTP!</i></small>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">NIP/NUPTK ( opsional )</label>
                                                            <input type="text" class="form-control" name="nip" value="{{ $g->nip }}">
                                                            <small class="form-text text-muted"><i>Isi NIP atau NUPTK di sini, pastikan sudah benar!</i></small>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Tempat Lahir*</label>
                                                            <input type="text" class="form-control" name="tempat_lahir" value="{{ $g->tempat_lahir }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal Lahir*</label>
                                                            <input type="date" class="form-control" name="tanggal_lahir" value="{{ $g->tanggal_lahir }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Jenis Kelamin*</label>
                                                            <select class="form-control" name="jenis_kelamin" required>
                                                                <option value="Laki-laki" {{ $g->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                                <option value="Perempuan" {{ $g->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Alamat*</label>
                                                            <textarea class="form-control" name="alamat" rows="3" required>{{ $g->alamat }}</textarea>
                                                            <small class="form-text text-muted"><i>Pastikan alamat ditulis dengan lengkap dan sesuai.</i></small>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Konsentrasi Keahlian*</label>
                                                            <select name="konke_id" class="form-control">
                                                                @foreach ($konkes as $konke)
                                                                <option value="{{ $konke->id }}" @if($konke->id == $g->konke_id) selected @endif>
                                                                    {{ $konke->name_konke }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
    
                                                        <div class="mb-3">
                                                            <label class="form-label">Email*</label>
                                                            <input type="email" class="form-control" name="email" value="{{ $g->email }}" required>
                                                            <small class="form-text text-muted"><i>Masukkan email aktif. Pastikan bisa diakses!</i></small>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">No HP*</label>
                                                            <input type="text" class="form-control" name="no_hp" value="{{ $g->no_hp }}" required>
                                                            <small class="form-text text-muted"><i>Masukkan nomor hp aktif. Pastikan bisa diakses!</i></small>
                                                        </div>
                                                        <!-- <div class="mb-3">
                                                            <label class="form-label">Role</label>
                                                            <select class="form-control" name="role" required>
                                                                <option value="guru" {{ $g->role == 'guru' ? 'selected' : '' }}>Guru</option>
                                                                <option value="kaprog" {{ $g->role == 'kaprog' ? 'selected' : '' }}>Kaprog</option>
                                                                <option value="hubin" {{ $g->role == 'hubin' ? 'selected' : '' }}>Hubin</option>
                                                                <option value="psekolah" {{ $g->role == 'psekolah' ? 'selected' : '' }}>Pimpinan Sekolah</option>
                                                            </select>
                                                        </div> -->
                                                        <div class="mb-3">
                                                            <label class="form-label">Password (Opsional)</label>
                                                            <input type="password" class="form-control" name="password">
                                                            <small class="form-text text-muted">Password minimal 8 karakter.</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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

                {{-- Modal Tambah --}}
                <div class="modal fade" id="tambahGuruModal" tabindex="-1" aria-labelledby="tambahGuruModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="tambahGuruModalLabel">Form Tambah Data Guru</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('guru.store') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Guru*</label>
                                        <input type="text" class="form-control" name="nama" required>
                                        <small class="form-text text-muted"><i>Nama lengkap ini akan tercatat di sistem, pastikan sudah benar!</i></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIK*</label>
                                        <input type="text" class="form-control" name="nik" required>
                                        <small class="form-text text-muted"><i>Isi NIK di sini ya, pastikan sesuai dengan data di KTP!</i></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIP/NUPTK (opsional)</label>
                                        <input type="text" class="form-control" name="nip">
                                        <small class="form-text text-muted"><i>Isi NIP atau NUPTK di sini, pastikan sudah benar!</i></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tempat Lahir*</label>
                                        <input type="text" class="form-control" name="tempat_lahir" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Lahir*</label>
                                        <input type="date" class="form-control" name="tanggal_lahir" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin*</label>
                                        <select class="form-control" name="jenis_kelamin" required>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alamat*</label>
                                        <textarea class="form-control" name="alamat" rows="3" required></textarea>
                                        <small class="form-text text-muted"><i>Pastikan alamat ditulis dengan lengkap dan sesuai.</i></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Konsentrasi Keahlian*</label>
                                        <select name="konkes_id" class="form-control">
                                            <option value="">Pilih Konsentrasi Keahlian (Opsional)</option> <!-- Opsi default -->
                                            @foreach ($konkes as $konke)
                                            <option value="{{ $konke->id }}">{{ $konke->name_konke }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email*</label>
                                        <input type="email" class="form-control" name="email" required> 
                                        <small class="form-text text-muted"><i>Masukkan email aktif. Pastikan bisa diakses!</i></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">No HP*</label>
                                        <input type="text" class="form-control" name="no_hp" required>
                                        <small class="form-text text-muted"><i>Masukkan nomor hp aktif. Pastikan bisa diakses!</i></small>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Role*</label>
                                        <select class="form-control" name="role" required>
                                            <option value="guru">Guru</option>
                                            <option value="kaprog">Kaprog</option>
                                            <option value="hubin">Hubin</option>
                                            <option value="psekolah">Pimpinan Sekolah</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password*</label>
                                        <input type="password" class="form-control" name="password" required>
                                        <small class="form-text text-muted">Password minimal 8 karakter.</small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah penghapusan langsung

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
                    this.closest('.delete-form').submit(); // Form terdekat dikirim
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