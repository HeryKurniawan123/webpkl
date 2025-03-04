@extends('layout.main')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tujuan Pembelajaran Iduka</title>
    <style>
        .card-content {
            transition: transform 0.3s ease-in-out;
        }

        .card-content:hover {
            transform: scale(1.02);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0">Tujuan Pembelajaran</h5>
                                <!-- Tombol Search (Desktop & Mobile) -->
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#searchModal">
                                        <i class="bi bi-search"></i>
                                        <span class="d-none d-md-inline">Search</span>
                                    </button>
                    
                                    <!-- Tombol Tambah TP -->
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahTpModal">
                                        <i class="bi bi-plus-lg"></i> <span class="d-none d-md-inline">Tambah TP</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    
                        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="searchModalLabel">Cari Tujuan Pembelajaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#">
                                            <input type="text" name="search" class="form-control" placeholder="Cari Tujuan Pembelajaran...">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card card-content mt-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <b>1. Nama Capaian Pembelajaran</b>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <a href="#" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash3"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" title="Download PDF">
                                            <i class="bi bi-file-earmark-pdf"></i> Cetak PDF
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-warning" href="#" data-bs-toggle="modal" data-bs-target="#editTpModal" title="Edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#">
                                            <i class="bi bi-trash3"></i> Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>1.1. Nama Tujuan Pembelajaran</li>
                                <li>1.2. Nama Tujuan Pembelajaran</li>
                                <li>1.3. Nama Tujuan Pembelajaran</li>
                            </ul>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahTpModal" tabindex="-1" aria-labelledby="tambahTpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Tambah Tujuan Pembelajaran Iduka</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('iduka_atp.store') }}" method="POST">
                @csrf
                <input type="hidden" name="iduka_id" id="iduka_id"> <!-- Hidden ID Iduka -->
                
                <div class="modal-body">
                    <div class="d-flex justify-content-center mb-3">
                        @foreach($konkes as $konke)
                        <button type="button" class="btn btn-primary m-1 jurusan-btn" data-konkes-id="{{ $konke->id }}">
                            {{ $konke->name_konke }}
                        </button>
                        @endforeach
                    </div>

                    <div id="cpTpContainer">
                        <label class="d-flex justify-content-end me-2">Check All<input type="checkbox" id="checkAllTambah"></label>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Tujuan Pembelajaran</th>
                                    <th>Checklist</th>
                                </tr>
                            </thead>
                            <tbody id="tp-tambah-body">
                                <!-- Data TP akan ditampilkan di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-sm">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- modaledit --}}
    <div class="modal fade" id="editTpModal" tabindex="-1" aria-labelledby="editTpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tujuan Pembelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Tujuan Pembelajaran</th>
                                <th>Checklist</th>
                            </tr>
                        </thead>
                        <tbody id="tp-edit-body">
                            <tr>
                                <td>1.1. Konsep Dasar</td>
                                <td><input type="checkbox" class="tp-check-edit" name="tp_check[]"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("checkAllTambah").addEventListener("click", function() {
            document.querySelectorAll("#tp-tambah-body .tp-check").forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        document.querySelectorAll(".jurusan-btn").forEach(button => {
            button.addEventListener("click", function(event) {
                event.preventDefault(); // Mencegah modal tertutup otomatis

                const konkes_id = this.getAttribute("data-konkes-id");
                document.getElementById("iduka_id").value = konkes_id; // Set ID Iduka ke hidden input
                const tpTambahBody = document.getElementById("tp-tambah-body");
                
                tpTambahBody.innerHTML = "<tr><td colspan='2'>Loading...</td></tr>";

                fetch(`/get-cp-atp/${konkes_id}`)
                    .then(response => response.json())
                    .then(data => {
                        tpTambahBody.innerHTML = "";

                        data.forEach(cp => {
                            let cpRow = `<tr><td><b>${cp.cp}</b></td><td></td></tr>`;
                            tpTambahBody.innerHTML += cpRow;

                            cp.atp.forEach((atp, index) => {
                                tpTambahBody.innerHTML += `
                                    <tr>
                                        <td style='padding-left: 20px;'>${index + 1}. ${atp.atp}</td>
                                        <td><input type='checkbox' class='tp-check' name='tp_check[]' value='${atp.id}'></td>
                                    </tr>
                                `;
                            });
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching data:", error);
                        tpTambahBody.innerHTML = "<tr><td colspan='2'>Gagal memuat data.</td></tr>";
                    });
            });
        });
    });
</script>

</html>
@endsection