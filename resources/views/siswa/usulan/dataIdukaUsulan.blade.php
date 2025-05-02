@extends('layout.main')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Data Institusi / Perusahaan</title>
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

        .btn-warning {
            background-color: #ffc107 !important;
            border-color: #ffc107 !important;
            color: black !important;
        }

        .btn-kuota {
            background-color: #ffc107;
            color: black;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            border-radius: 50px;
            border: 2px solid #ffc107;
        }

        .btn-kuota:hover {
            background-color: white;
            color: #ffc107;
            border-color: white;
        }

        .card-hover:hover .btn-kuota {
            background-color: white;
            color: #ffbf00;
            border-color: white;
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

                                <div class="d-none d-md-flex gap-2 align-items-center">
                                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-primary btn-back btn-sm shadow-sm">
                                        <i class="bi bi-arrow-left-circle"></i>
                                        <span class="d-none d-md-inline">Kembali</span>
                                    </a>
                                    <select class="form-select form-select-sm w-auto" id="filterIduka">
                                        <option value="all">Semua</option>
                                        <option value="rekomendasi">Rekomendasi</option>
                                        <option value="ajuan">Ajuan</option>
                                    </select>
                                    <div class="d-flex align-items-center">
                                        <div class="dropdown ms-2">
                                            <button class="btn dropdown-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                &#x22EE; <!-- Simbol titik tiga vertikal (⋮) -->
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a href="{{ route('usulan.index') }}" class="dropdown-item">
                                                        Buat Usulan
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#searchModal">
                                                        Cari
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="d-flex d-md-none justify-content-end">
                                <div class="dropdown">
                                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                       <i class="bi bi-three-dots-vertical"></i>                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a href="{{ route('siswa.dashboard') }}" class="dropdown-item text-primary">
                                        <i class="bi bi-arrow-left-circle me-2"></i> Kembali
                                        </a>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#searchModal">
                                        <i class="bi bi-search me-2"></i> Cari
                                        </button>
                                    </li>
                                    <li>
                                        <div class="px-3 pt-2">
                                        <select class="form-select form-select-sm" id="filterIdukaMobile">
                                            <option value="all">Semua</option>
                                            <option value="rekomendasi">Rekomendasi</option>
                                            <option value="ajuan">Ajuan</option>
                                        </select>
                                        </div>
                                    </li>
                                    </ul>
                                </div>
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
                            Belum ada data institusi / perusahaan yang tersedia.
                        </div>
                        @else
                        @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @foreach ($iduka as $i)
                        @php
                        $kuota = $i->kuota_pkl; // Pastikan kolom ini ada di tabel iduka
                        @endphp

                        <div class="card mb-3 shadow-sm card-hover p-3 {{ $kuota <= 0 ? 'bg-light text-muted' : '' }}" style="border-radius: 10px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div style="min-width: 0;">
                                    <div class="fw-bold text-truncate d-inline-block w-100" style="font-size: 16px; max-height: 40px; overflow: hidden;">
                                        {{ $i->nama }}
                                    </div>
                                    <!-- Alamat dengan text-truncate -->
                                    <div class="text-muted text-truncate w-100" style="font-size: 14px;">
                                        {{ $i->alamat }}
                                    </div>
                                    @if ($i->rekomendasi == 1)
                                    <div class="text-success mt-1" style="font-size: 13px;">
                                        <strong>Rekomendasi:</strong> Institusi ini direkomendasikan
                                    </div>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center">
                                    @php
                                    $awal = $i->tanggal_awal;
                                    $akhir = $i->tanggal_akhir;
                                    @endphp
                                    @if ($kuota <= 0)
                                        <button
                                        class="btn btn-kuota rounded-pill btn-sm btn-detail"
                                        data-nama="{{ $i->nama }}">
                                        Kuota Penuh
                                        </button>
                                        @else
                                        <button
                                            class="btn btn-hover rounded-pill btn-sm btn-detail"
                                            data-id="{{ $i->id }}"
                                            data-url="{{ route('detail.datausulan', $i->id) }}"
                                            data-awal="{{ $awal }}"
                                            data-akhir="{{ $akhir }}">
                                            Detail
                                        </button>
                                        @endif
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.detail-disabled').forEach(btn => {
            btn.addEventListener('click', function() {
                let nama = this.getAttribute('data-nama');
                Swal.fire({
                    icon: 'info',
                    title: 'Institusi Ditutup',
                    text: 'Pendaftaran ke Institusi / Perusahaan "' + nama + '" sudah ditutup.',
                    confirmButtonColor: '#7e7dfb'
                });
            });
        });
    </script>

</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.querySelector('input[name="search"]');
        const filterSelect = document.getElementById("filterIduka");
        const idukaCards = document.querySelectorAll(".card-hover");
        const detailButtons = document.querySelectorAll(".btn-detail");

        function filterData() {
            const searchValue = searchInput.value.toLowerCase();
            const filterValue = filterSelect.value;

            idukaCards.forEach(card => {
                const nama = card.querySelector(".mb-0").textContent.toLowerCase(); // Ambil nama Iduka
                const alamat = card.querySelector(".text-muted")?.textContent.toLowerCase() || ''; // Ambil alamat Iduka
                const isRekomendasi = card.querySelector(".text-success") !== null; // Cek apakah ada label rekomendasi

                let matchesSearch = nama.includes(searchValue) || alamat.includes(searchValue);
                let matchesFilter =
                    filterValue === "all" ||
                    (filterValue === "rekomendasi" && isRekomendasi) ||
                    (filterValue === "ajuan" && !isRekomendasi);

                // Tampilkan atau sembunyikan kartu berdasarkan filter
                card.style.display = (matchesSearch && matchesFilter) ? "block" : "none";
            });
        }

        searchInput.addEventListener("input", filterData);
        filterSelect.addEventListener("change", filterData);

        detailButtons.forEach(button => {
            button.addEventListener("click", function() {
                const awal = this.dataset.awal;
                const akhir = this.dataset.akhir;
                const url = this.dataset.url;
                const now = new Date();

                // Jika tanggal kosong, izinkan masuk
                if (!awal || !akhir) {
                    window.location.href = url;
                    return;
                }

                // Konversi ke objek Date
                const startDate = new Date(awal);
                const endDate = new Date(akhir);

                // Buat tanggal hari ini tanpa jam
                const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());

                if (today >= startDate && today <= endDate) {
                    // Masih dalam rentang waktu, izinkan masuk
                    window.location.href = url;
                } else {
                    // Di luar rentang waktu
                    Swal.fire({
                        icon: 'warning',
                        title: 'Institusi Ditutup',
                        text: 'Maaf, Waktu Pendaftaran belum dimulai atau sudah melebihi tenggat waktu',
                        confirmButtonColor: '#7e7dfb'
                    });
                }
            });
        });
    });
</script>

@endsection