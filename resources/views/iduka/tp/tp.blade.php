@extends('layout.main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tujuan Pembelajaran Iduka</title>
</head>
<style>
    .card-content {
        transition: transform 0.3s ease-in-out;
    }

    .card-content:hover {
        transform: scale(1.02);
    }
</style>
<body>
    <div class="container-fluid">
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <form action="#" class="d-flex" style="width: 100%; max-width: 500px;">
                                    <input type="text" name="search" class="form-control me-2" placeholder="Cari Tujuan Pembelajaran..." style="flex: 1; min-width: 250px;">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </form>
        
                                <div class="d-flex gap-2">      
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahTpModal"> Tambah TP
                                    </button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="card card-content mt-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <b>1. Nama Capaian Pembelajaran</b>
                            <div>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editTpModal">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <a href="#" class="btn btn-sm btn-danger" type="button">
                                    <i class="bi bi-trash3"></i> 
                                </a>           
                            </div>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>1.1. Nama Tujuan pembelajaran</li>
                                <li>1.2. Nama Tujuan pembelajaran</li>
                                <li>1.3. Nama Tujuan pembelajaran</li>
                                <li>1.4. Nama Tujuan pembelajaran</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahTpModal" tabindex="-1" aria-labelledby="tambahTpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tambahTpModalLabel">Tambah Tujuan Pembelajaran Iduka</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <div class="card-body">
                            <h5>1. Nama Capaian Pembelajaran</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Tujuan Pembelajaran</th>
                                        <th>Checklist</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.1. Memahami konsep dasar pemrograman</td>
                                        <td><input type="checkbox" name="tp_check[]" value="1.1"></td>
                                    </tr>
                                    <tr>
                                        <td>1.2. Menggunakan sintaks dasar dalam pemrograman</td>
                                        <td><input type="checkbox" name="tp_check[]" value="1.2"></td>
                                    </tr>
                                    <tr>
                                        <td>1.3. Mengimplementasikan logika pemrograman</td>
                                        <td><input type="checkbox" name="tp_check[]" value="1.3"></td>
                                    </tr>
                                </tbody>
                            </table>

                            {{-- yangkedua --}}
                            <h5>1. Nama Capaian Pembelajaran</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Tujuan Pembelajaran</th>
                                        <th>Checklist</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1.1. Memahami konsep dasar pemrograman</td>
                                        <td><input type="checkbox" name="tp_check[]" value="1.1"></td>
                                    </tr>
                                    <tr>
                                        <td>1.2. Menggunakan sintaks dasar dalam pemrograman</td>
                                        <td><input type="checkbox" name="tp_check[]" value="1.2"></td>
                                    </tr>
                                    <tr>
                                        <td>1.3. Mengimplementasikan logika pemrograman</td>
                                        <td><input type="checkbox" name="tp_check[]" value="1.3"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary">Simpan Data</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- editTP --}}
    <div class="modal fade" id="editTpModal" tabindex="-1" aria-labelledby="editTpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editTpModalLabel">Form Edit Tujuan Pembelajaran Iduka</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Capaian Pembelajaran</label>
                        <input type="text" class="form-control" name="nama_cp" placeholder="Nama Capaian Pembelajaran" required>
                    </div>
                    <div id="tpFieldsEdit">
                        <label class="form-label">Nama Tujuan Pembelajaran</label>
                        <div class="input-group mb-2">
                            <input type="text" name="nama_tp[]" class="form-control" placeholder="Nama Tujuan Pembelajaran">
                            <button type="button" class="btn btn-secondary" onclick="removeTpField(this)">
                                -
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" onclick="addTpFieldEdit()">
                        <i class="bi bi-plus-lg"></i> Tambah TP
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
@endsection