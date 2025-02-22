@extends('layout.main')
@section('content')
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <form action="{{ route('proker.index') }}" method="GET" class="d-flex" style="width: 100%; max-width: 500px;">
                                <input type="text" name="search" class="form-control me-2" placeholder="Cari Guru..." style="flex: 1; min-width: 250px;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> 
                                </button>
                            </form>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahGuruModal">
                                Tambah Data
                            </button>
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Guru</th>
                                    <th>NIK</th>
                                    <th>NIP/NUPTK</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>aaa</td>
                                    <td>aaa</td>
                                    <td>aaa</td>
                                    <td>aaa</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editGuruModal">
                                            <i class="bi bi-pen"></i>
                                        </button>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#detailGuruModal">
                                            <i class="bi bi-pen"></i>
                                        </button>
                                        @include('hubin.dataguru.detailGuru')
                                        <form action="#" method="POST" class="delete-btn d-inline">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- Modal Edit --}}
                                <div class="modal fade" id="editGuruModal" tabindex="-1" aria-labelledby="editGuruModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="editGuruModalLabel">Form Edit Data Guru</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="#" method="POST">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Guru</label>
                                                    <input type="text" class="form-control" name="#" placeholder="Masukkan Nama Guru" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">NIK</label>
                                                    <input type="text" class="form-control" name="#" placeholder="Masukkan NIK" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">NIP/NUPTK (opsional)</label>
                                                    <input type="text" class="form-control" name="#" placeholder="Masukkan NIP/NUPTK">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tempat Lahir</label>
                                                    <input type="text" class="form-control" name="#" placeholder="Masukkan Tempat Lahir" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Lahir</label>
                                                    <input type="date" class="form-control" name="#" placeholder="Masukkan Tanggal Lahir" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Jenis Kelamin</label>
                                                    <select class="form-control" name="#" required>
                                                        <option value="">Pilih Jenis Kelamin</option>
                                                        <option value="">Laki-laki</option>
                                                        <option value="">Perempuan</option>
                                                    </select>
                                                </div> 
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat</label>
                                                    <input type="text" class="form-control" name="#" placeholder="Masukkan Alamat" required>
                                                    <textarea class="form-control" name="alamat" rows="3" placeholder="Masukkan Alamat" required></textarea>                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Konsentrasi Keahlian</label>
                                                    <select class="form-control" name="#" required>
                                                        <option value="">Pilih Konsentrasi Keahlian</option>
                                                            <option value="#">ontoh</option>
                                                    </select>
                                                </div> 
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="text" class="form-control" name="#" placeholder="Masukkan Email" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">No HP</label>
                                                    <input type="text" class="form-control" name="#" placeholder="Masukkan No HP" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" class="form-control" name="#" placeholder="Masukkan Password" required>
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
                            </tbody>
                        </table>
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
                        <form action="#" method="POST">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nama Guru</label>
                                    <input type="text" class="form-control" name="#" placeholder="Masukkan Nama Guru" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">NIK</label>
                                    <input type="text" class="form-control" name="#" placeholder="Masukkan NIK" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">NIP/NUPTK (opsional)</label>
                                    <input type="text" class="form-control" name="#" placeholder="Masukkan NIP/NUPTK">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" name="#" placeholder="Masukkan Tempat Lahir" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="#" placeholder="Masukkan Tanggal Lahir" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select class="form-control" name="#" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="">Laki-laki</option>
                                        <option value="">Perempuan</option>
                                    </select>
                                </div> 
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" class="form-control" name="#" placeholder="Masukkan Alamat" required>
                                    <textarea class="form-control" name="alamat" rows="3" placeholder="Masukkan Alamat" required></textarea>                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Konsentrasi Keahlian</label>
                                    <select class="form-control" name="#" required>
                                        <option value="">Pilih Konsentrasi Keahlian</option>
                                            <option value="#">ontoh</option>
                                    </select>
                                </div> 
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" name="#" placeholder="Masukkan Email" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">No HP</label>
                                    <input type="text" class="form-control" name="#" placeholder="Masukkan No HP" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="#" placeholder="Masukkan Password" required>
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
</script>
@endsection
