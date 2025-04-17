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
            position: relative;
            /* Pastikan elemen ini menjadi referensi posisi */
        }

        .card-hover:hover {
            transform: scale(1.03);
            background-color: #7e7dfb !important;
            color: white !important;
            z-index: 1;
            /* Pastikan card tetap di bawah dropdown */
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

        .dropdown-menu {
            z-index: 9999 !important;
            /* Pastikan dropdown selalu di atas */
            position: absolute !important;
            /* Jangan biarkan Bootstrap mengubahnya */
            transform: translate3d(0px, 0px, 0px) !important;
            will-change: transform;
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
                                <h5 class="mb-0">Data Kelas</h5>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#searchModal">
                                        <i class="bi bi-search"></i>
                                        <span class="d-none d-md-inline">Search</span>
                                    </button>
                    
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahKelasModal">
                                        <i class="bi bi-plus-lg"></i> <span class="d-none d-md-inline">Tambah</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    
                        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="searchModalLabel">Cari Kelas</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="GET">
                                            <div class="mb-3">
                                                <label for="kelas" class="form-label">Pilih Kelas</label>
                                                <select name="kelas" id="kelas" class="form-control">
                                                    <option value="">-- Pilih Kelas --</option>
                                                    <option value="X">X</option>
                                                    <option value="XI">XI</option>
                                                    <option value="XII">XII</option>
                                                </select>
                                            </div>
                        
                                            <div class="mb-3">
                                                <label for="konsentrasi" class="form-label">Pilih Konsentrasi Keahlian</label>
                                                <select name="konsentrasi" id="konsentrasi" class="form-control">
                                                    <option value="">-- Pilih Konsentrasi Keahlian --</option>
                                                    <option value="RPL">Rekayasa Perangkat Lunak</option>
                                                    <option value="TKJ">Teknik Komputer dan Jaringan</option>
                                                    <option value="DKV">Desain Komunikasi Visual</option>
                                                    <option value="TKRO">Teknik Kendaraan Ringan Otomotif</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>


                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @forelse ($kelas as $item)
                    <div class="col-md-4">
                        <div class="card mb-3 shadow-sm card-hover" style="padding: 30px; border-radius: 10px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="mb-0" style="font-size: 18px">{{ $item->kelas ?? '-'  }} {{ $item->name_kelas ?? '-' }}</div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('siswa.kelas', ['id' => $item->id]) }}" class="btn btn-hover rounded-pill">Detail</a>
                                    <button class="btn dropdown-btn" type="button" data-bs-toggle="dropdown"
                                        data-bs-display="static" aria-expanded="false">⋮</button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <form action="{{ route('kelas.destroy', $item->id) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Hapus</button>
                                            </form>
                                        </li>
                                        <li>
                                            <button class="dropdown-item text-warning" data-bs-toggle="modal"
                                                data-bs-target="#editKelasModal{{ $item->id }}">
                                                Edit
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center">Tidak ada data kelas yang tersedia.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kelas -->
    <div class="modal fade" id="tambahKelasModal" tabindex="-1" aria-labelledby="tambahKelasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tambahKelasModalLabel">Form Tambah Kelas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kelas.store') }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kelas*</label>
                            <select class="form-control" name="kelas" required>
                                <option value="">Pilih Kelas</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konsentrasi Keahlian*</label>
                            <select class="form-control" name="konke_id" required>
                                <option value="">Pilih Konsentrasi Keahlian</option>
                                @foreach($konke as $k)
                                <option value="{{ $k->id }}">{{ $k->name_konke }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label">Nama Kelas*</label>
                            <input type="text" class="form-control" id="name_kelas" name="name_kelas" placeholder="Masukkan Nama Kelas" required>
                            <small class="form-text text-muted"><i>Nama ini akan terlihat oleh semua pengguna, pastikan sudah benar ya!</i></small>
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

    <div class="modal fade" id="editKelasModal{{ $item->id ?? '-' }}" tabindex="-1" aria-labelledby="editKelasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editKelasModalLabel">Form Tambah Kelas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kelas.update', $item->id ?? '-') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kelas*</label>
                            <select class="form-control" name="kelas" required>
                                <option value="">Pilih Kelas</option>
                                <option value="X" {{ isset($item) && $item->kelas == 'X' ? 'selected' : '' }}>X</option>
                                <option value="XI" {{ isset($item) && $item->kelas == 'XI' ? 'selected' : '' }}>XI</option>
                                <option value="XII" {{ isset($item) && $item->kelas == 'XII' ? 'selected' : '' }}>XII</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Konsentrasi Keahlian*</label>
                            <select class="form-control" name="konke_id" required>
                                <option value="">Pilih Konsentrasi Keahlian</option>
                                @foreach($konke as $k)
                                <option value="{{ $k->id ?? '-' }}"
                                    {{ isset($item) && $item->konke_id == $k->id ? 'selected' : '' }}>
                                    {{ $k->konke }} {{ $k->name_konke }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nama_kelas" class="form-label">Nama Kelas*</label>
                            <input type="text" class="form-control" id="name_kelas" name="name_kelas" value="{{ $item->name_kelas ?? '-'}}" placeholder="Masukkan Nama Kelas" required>
                            <small class="form-text text-muted"><i>Nama ini akan terlihat oleh semua pengguna, pastikan sudah benar ya!</i></small>
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

        document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".dropdown-btn").forEach(function(btn) {
                    btn.addEventListener("click", function() {
                        let dropdownMenu = this.nextElementSibling;

                        // Hapus semua dropdown yang sudah aktif
                        document.querySelectorAll(".dropdown-menu").forEach(menu => {
                            if (menu !== dropdownMenu) {
                                menu.style.zIndex =
                                "9999"; // Pastikan semua dropdown tetap di atas
                            }
                        });

                        // Pastikan dropdown saat ini di atas semua elemen
                        dropdownMenu.style.zIndex = "10000";
                    });
                });

                // Tutup dropdown saat klik di luar
                document.addEventListener("click", function(event) {
                    if (!event.target.matches(".dropdown-btn")) {
                        document.querySelectorAll(".dropdown-menu").forEach(menu => {
                            menu.style.zIndex = "9999";
                        });
                    }
                });
            });



            document.getElementById("searchInput").addEventListener("keyup", function() {
                let filter = this.value.toLowerCase();
                let cards = document.querySelectorAll(".card-hover");

                cards.forEach(card => {
                    let title = card.querySelector(".kelas-title").textContent.toLowerCase();
                    card.style.display = title.includes(filter) ? "" : "none";
                });
            });

    </script>
</body>

</html>
@endsection