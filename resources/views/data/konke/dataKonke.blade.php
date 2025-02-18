@extends('layout.main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Konsentrasi Keahlian</title>
</head>
<body>
    <div class="container-fluid">
        <div class="content-wrapper">
            <div class="container-xxl fluid flex-grow-1 container-p-y">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <form action="#" class="d-flex" style="width: 100%; max-width: 500px;">
                                <input type="text" name="search" class="form-control me-2" placeholder="Cari Konsentrasi Keahlian" style="flex: 1; min-width: 250px;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> 
                                </button>
                            </form>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKonkeModal">
                                Tambah Data
                            </button>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Konsentrasi Keahlian</td>
                                    <td>Program Kerja</td>
                                    <td>Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>No</td>
                                    <td>Konsentrasi Keahlian</td>
                                    <td>Program Kerja</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editKonkeModal">
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
                
                {{-- create konke --}}
                <div class="modal fade" id="tambahKonkeModal" tabindex="-1" aria-labelledby="tambahKonkeModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="tambahKonkeModalLabel">Form Tambah Konsentrasi Keahlian</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="" class="form-label">Konsentrasi Keahlian</label>
                                <input type="text" class="form-control" id="" name="" placeholder="Masukkan Konsentrasi Keahlian" required>
                            </div>
                            <div class="mb-3">
                                <label for="program_kerja" class="form-label">Program Kerja</label>
                                <select class="form-control" id="program_kerja" name="program_kerja" required>
                                    <option value="">Pilih Program Kerja</option> <!--mengambil proker_id-->
                                    <option value="">Teknik</option>
                                    {{-- @foreach($programKerja as $program)
                                        <option value="{{ $program->id }}">{{ $program->nama }}</option>
                                    @endforeach --}}
                                </select>
                            </div>                            
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                          <button type="button" class="btn btn-primary">Simpan Data</button>
                        </div>
                      </div>
                    </div>
                </div>
                
                {{-- create konke --}}
                <div class="modal fade" id="editKonkeModal" tabindex="-1" aria-labelledby="editKonkeModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="editKonkeModalLabel">Form Edit Konsentrasi Keahlian</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="" class="form-label">Konsentrasi Keahlian</label>
                                <input type="text" class="form-control" id="" name="" placeholder="Masukkan Konsentrasi Keahlian" required>
                            </div>
                            <div class="mb-3">
                                <label for="program_kerja" class="form-label">Program Kerja</label>
                                <select class="form-control" id="program_kerja" name="program_kerja" required>
                                    <option value="">Pilih Program Kerja</option> <!--mengambil proker_id-->
                                    <option value="">Teknik</option>
                                    {{-- @foreach($programKerja as $program)
                                        <option value="{{ $program->id }}">{{ $program->nama }}</option>
                                    @endforeach --}}
                                </select>
                            </div>                            
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                          <button type="button" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.delete-btn').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); 

            Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
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