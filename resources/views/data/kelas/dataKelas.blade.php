@extends('layout.main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Kelas</title>
    <style>
        .card-hover {
            transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
        }
        .card-hover:hover {
            transform: scale(1.03);
            background-color: #7e7dfb !important;
            color: white !important;
        }
        .card-hover:hover .btn-hover {
            background-color: white;
            color: #7e7dfb;
            border-color: white;
        }
        .btn-hover {
            background-color: #7e7dfb;
            color: white;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            border-radius: 50px;
            border: 2px solid #7e7dfb;
        }
        .btn-hover:hover {
            background-color: white;
            color: #7e7dfb;
            border-color: white;
        }
        .dropdown-btn {
            color: #7e7dfb;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            border-radius: 50px;
            padding: 5px 12px;
            font-size: 25px;
        }
        .card-hover:hover .dropdown-btn {
            color: white !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <form action="#" class="d-flex" style="width: 100%; max-width: 500px;">
                            <input type="text" name="search" class="form-control me-2" placeholder="Cari Kelas" style="flex: 1; min-width: 250px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> 
                            </button>
                        </form>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKelasModal">
                            Tambah Data
                        </button>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3 shadow-sm card-hover" style="padding: 30px; border-radius: 10px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="mb-0" style="font-size: 18px">XII RPL 2</div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('siswa.kelas') }}" class="btn btn-hover rounded-pill">Detail</a>
                                    <div class="dropdown ms-2">
                                        <button class="btn dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            ⋮
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                 {{-- <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus iduka ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">Hapus</button>
                                                </form> --}}
                                                <button type="submit" class="dropdown-item text-danger delete-btn">Hapus</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>   
                </div>
                    {{-- create proker --}}
                    <div class="modal fade" id="tambahKelasModal" tabindex="-1" aria-labelledby="tambahKelasModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="tambahKelasModalLabel">Form Tambah Kelas</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="program_kerja" class="form-label">Kelas</label>
                                    <select class="form-control" id="program_kerja" name="program_kerja" required>
                                        <option value="">Pilih Kelas</option> <!--ngambil proker_id-->
                                        <option value="">XI</option>
                                        <option value="">XII</option>
                                        {{-- @foreach($programKerja as $program)
                                            <option value="{{ $program->id }}">{{ $program->nama }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="program_kerja" class="form-label">Konsentrasi Keahlian</label>
                                    <select class="form-control" id="program_kerja" name="program_kerja" required>
                                        <option value="">Pilih Konsentrasi Keahlian</option> <!--ngambil proker_id-->
                                        <option value="">Rekayasa Perangkat Lunak</option>
                                        {{-- @foreach($programKerja as $program)
                                            <option value="{{ $program->id }}">{{ $program->nama }}</option>
                                        @endforeach --}}
                                    </select>
                                </div> 
                                <div class="mb-3">
                                    <label for="" class="form-label">Kelas</label>
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
                    <div class="modal fade" id="editProker" tabindex="-1" aria-labelledby="editProkerLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="editProkerLabel">Form Edit Program Kerja</h1>
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