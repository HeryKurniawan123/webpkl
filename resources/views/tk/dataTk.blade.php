@extends('layout.main')
@section('content')
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <form action="#" method="GET" class="d-flex" style="width: 100%; max-width: 500px;">
                                <input type="text" name="search" class="form-control me-2" placeholder="Cari Tenaga Kependidikan..." style="flex: 1; min-width: 250px;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i>
                                </button>
                            </form>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahTkModal">
                                Tambah Data
                            </button>
                        </div>
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        <table class="table table-hover">
                            <thead>
                                <th>No</th>
                                <th>Nama GTK</th>
                                <th>NIK</th>
                                <th>NIP/NUPTK</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($kependik as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->nip_nuptk ?? '-' }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editTkModal{{ $item->id }}">
                                            <i class="bi bi-pen"></i>
                                        </button>

                                        <!-- Tombol Detail -->
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailTkModal{{ $item->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>


                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('kependik.destroy', $item->id) }}" method="POST" class="delete-btn d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editTkModal{{ $item->id }}" tabindex="-1" aria-labelledby="editTkModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editTkModalLabel">Form Edit Data Tenaga Kependidikan</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('kependik.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama GTK</label>
                                                        <input type="text" class="form-control" name="nama" value="{{ $item->nama }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">NIK</label>
                                                        <input type="text" class="form-control" name="nik" value="{{ $item->nik }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">NIP/NUPTK (opsional)</label>
                                                        <input type="text" class="form-control" name="nip_nuptk" value="{{ $item->nip_nuptk }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tempat Lahir</label>
                                                        <input type="text" class="form-control" name="tempat_lahir" value="{{ $item->tempat_lahir }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal Lahir</label>
                                                        <input type="date" class="form-control" name="tanggal_lahir" value="{{ $item->tanggal_lahir }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Jenis Kelamin</label>
                                                        <select class="form-control" name="jenis_kelamin" required>
                                                            <option value="Laki-laki" {{ $item->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                            <option value="Perempuan" {{ $item->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Alamat</label>
                                                        <textarea class="form-control" name="alamat" rows="3" required>{{ $item->alamat }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" class="form-control" name="email" value="{{ $item->email }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">No HP</label>
                                                        <input type="text" class="form-control" name="no_hp" value="{{ $item->no_hp }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Password (Kosongkan jika tidak ingin diubah)</label>
                                                        <input type="password" class="form-control" name="password" placeholder="Masukkan Password Baru">
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

                {{-- Modal Tambah --}}
                <div class="modal fade" id="tambahTkModal" tabindex="-1" aria-labelledby="tambahTkModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="tambahTkModalLabel">Form Tambah Data Tenaga Kependidikan</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('kependik.store') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama GTK</label>
                                        <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama GTK" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIK</label>
                                        <input type="text" class="form-control" name="nik" placeholder="Masukkan NIK" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIP/NUPTK (opsional)</label>
                                        <input type="text" class="form-control" name="nip_nuptk" placeholder="Masukkan NIP/NUPTK">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" name="tempat_lahir" placeholder="Masukkan Tempat Lahir" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="tanggal_lahir" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select class="form-control" name="jenis_kelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" name="alamat" rows="3" placeholder="Masukkan Alamat" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">No HP</label>
                                        <input type="text" class="form-control" name="no_hp" placeholder="Masukkan No HP" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="Masukkan Password" required>
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
@include('tk.detailTK')
<script>
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
        const form = document.querySelector("#tambahTkModal form");

        form.addEventListener("submit", function(event) {
            const password = form.querySelector("[name='password']").value;
            if (password.length < 6) {
                event.preventDefault();
                alert("Password minimal 6 karakter!");
            }
        });
    });
</script>

@endsection