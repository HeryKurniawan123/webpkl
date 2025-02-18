@extends('layout.main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Program Kerja</title>
</head>
<body>
    <div class="container-fluid">
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <form action="#" class="d-flex" style="width: 100%; max-width: 500px;">
                                    <input type="text" name="search" class="form-control me-2" placeholder="Cari Program Kerja" style="flex: 1; min-width: 250px;">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i> 
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahProkerModal">
                                    Tambah Data
                                </button>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Program Kerja</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>Teknik</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editProkerModal">
                                                <i class="bi bi-pen"></i>
                                            </button>
                                            {{-- <a href="#" class="btn btn-info btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a> --}}
                                            <form action="#" style="display:inline;" class="delete-btn">
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash3"></i>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- create proker --}}
                    <div class="modal fade" id="tambahProkerModal" tabindex="-1" aria-labelledby="tambahProkerModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="tambahProkerModalLabel">Form Tambah Program Kerja</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="" class="form-label">Program Kerja</label>
                                    <input type="text" class="form-control" id="" name="" placeholder="Masukkan Program Kerja" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                              <button type="button" class="btn btn-primary">Simpan Data</button>
                            </div>
                          </div>
                        </div>
                    </div>

                    {{-- edit proker --}}
                    <div class="modal fade" id="editProkerModal" tabindex="-1" aria-labelledby="editProkerModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="editProkerModalLabel">Form Edit Program Kerja</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="" class="form-label">Program Kerja</label>
                                    <input type="text" class="form-control" id="" name="" placeholder="Masukkan Program Kerja" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                              <button type="button" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
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
                Swal.fire({
                title: "Berhasil dihapus!",
                text: "Data telah dihapus.",
                icon: "success"
                });
            }
            });
        });
    });
    </script>
</body>
</html>
@endsection