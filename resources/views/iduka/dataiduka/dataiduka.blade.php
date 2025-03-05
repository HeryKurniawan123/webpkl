@extends('layout.main')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Data Iduka</title>
    <style>
        .card-hover {
            transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
        }

        .card-hover:hover {
            transform: scale(1.03);
            background-color: #7e7dfb !important;
            /* Warna diperbaiki */
            color: white !important;
            /* Agar teks berubah saat hover */
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
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0">Data Institusi / Perusahaan</h5>
                            
                                <!-- Desktop Layout: Filter -> Search -> Tambah -->
                                <div class="d-none d-md-flex gap-2 align-items-center">
                                    <select class="form-select form-select-sm w-auto" id="filterIduka">
                                        <option value="all">Semua</option>
                                        <option value="rekomendasi">Rekomendasi</option>
                                        <option value="ajuan">Ajuan</option>
                                    </select>  
                            
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#searchModal">
                                        <i class="bi bi-search"></i>
                                    </button>
                            
                                    @if(in_array(auth()->user()->role, ['hubin', 'kaprog']))
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahIdukaModal">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                    @endif
                                </div>
                            
                                <!-- Mobile Layout -->
                                <div class="d-flex d-md-none flex-column align-items-end">
                                    <!-- Search & Tambah -->
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#searchModal">
                                            <i class="bi bi-search"></i>
                                        </button>
                            
                                        @if(in_array(auth()->user()->role, ['hubin', 'kaprog']))
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahIdukaModal">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                        @endif
                                    </div>
                            
                                    <!-- Dropdown filter di bawah, tetap ke kanan -->
                                    <select class="form-select form-select-sm w-auto mt-2" id="filterIdukaMobile">
                                        <option value="all">Semua</option>
                                        <option value="rekomendasi">Rekomendasi</option>
                                        <option value="ajuan">Ajuan</option>
                                    </select>  
                                </div>
                            </div>                                                                                                               
                        </div>
                    
                        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="searchModalLabel">Cari Institusi / Perusahaan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#">
                                            <input type="text" name="search" class="form-control" placeholder="Cari Institusi / Perusahaan...">
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
                        @if ($iduka->isEmpty())
                            <div class="alert alert-warning">
                                Belum ada data Iduka yang tersedia.
                            </div>
                        @else
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif   
                            @foreach ($iduka as $i)
                            <div class="card mb-3 shadow-sm card-hover p-3" style="border-radius: 10px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div style="min-width: 0;">
                                        <!-- Nama Iduka dengan batas 2 baris -->
                                        <div class="fw-bold text-truncate d-inline-block w-100" style="font-size: 16px; max-height: 40px; overflow: hidden;">
                                            {{ $i->nama }}
                                        </div>
                                        <!-- Alamat dengan text-truncate -->
                                        <div class="text-muted text-truncate w-100" style="font-size: 14px;">
                                            {{ $i->alamat }}
                                        </div>
                                        @if ($i->rekomendasi == 1)
                                        <div class="text-success mt-1" style="font-size: 13px;">
                                            <strong>Rekomendasi:</strong> IDUKA ini direkomendasikan
                                        </div>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('detail.iduka', $i->id) }}" class="btn btn-hover rounded-pill btn-sm">Detail</a>
                                        <div class="dropdown ms-2">
                                            <button class="btn dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                ⋮
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <form action="{{ route('iduka.destroy', $i->id) }}" method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="delete-btn dropdown-item text-danger">Hapus</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
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
    </script>

    @include('iduka.dataiduka.createiduka')
</body>

</html>
@endsection