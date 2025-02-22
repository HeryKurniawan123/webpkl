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
                background-color: #7e7dfb !important; /* Warna diperbaiki */
                color: white !important; /* Agar teks berubah saat hover */
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
                    <form action="{{ route('data.iduka') }}" method="GET" class="d-flex" style="width: 100%; max-width: 500px;">
                            <input type="text" name="search" class="form-control me-2" placeholder="Cari Iduka..." style="flex: 1; min-width: 250px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> 
                            </button>
                        </form>
                    
                        <div class="d-flex gap-2">
                            <select class="form-select w-auto" id="filterIduka">
                                <option value="all">Semua</option>
                                <option value="rekomendasi">Rekomendasi</option>
                                <option value="ajuan">Ajuan</option>
                            </select>
                    
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahIdukaModal">
                                Tambah Iduka
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-md-12 mt-3">
                        @if ($idukas->isEmpty()) 
                            <div class="alert alert-warning">
                                Belum ada data Iduka yang tersedia.
                            </div>
                        @else
                            @foreach ($idukas as $iduka)
                                <div class="card mb-3 shadow-sm card-hover" style="padding: 30px; border-radius: 10px;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="mb-0" style="font-size: 18px">{{ $iduka->nama }}</div>
                                            <div class="">{{ $iduka->alamat }}</div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('detail.iduka', $iduka->id) }}" class="btn btn-hover rounded-pill">Detail</a>
                                            <div class="dropdown ms-2">
                                                <button class="btn dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    ⋮
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <form action="{{ route('iduka.destroy', $iduka->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus iduka ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">Hapus</button>
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

        @include('iduka.dataiduka.createiduka')
    </body>
    </html>
@endsection