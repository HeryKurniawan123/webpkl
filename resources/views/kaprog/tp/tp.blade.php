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
    <div class="container mt-4">

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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahCpTpModal"> Tambah TP
                        </button>
                    </div>
                </div>                            
            </div>
        </div>

        {{-- Card CP dan TP --}}
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

        {{-- tambahTP --}}
        <div class="modal fade" id="tambahCpTpModal" tabindex="-1" aria-labelledby="tambahCpTpModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="tambahCpTpModalLabel">Form Tambah Tujuan Pembelajaran</h1>
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
    </div>


<script>
    function addTpFieldTambah() {
        let input = document.createElement('input');
        input.type = 'text';
        input.name = 'nama_tp[]';
        input.className = 'form-control mb-2';
        input.placeholder = 'Nama Tujuan Pembelajaran';
        document.getElementById('tpFieldsTambah').appendChild(input);
    }

    function addTpFieldEdit() {
        let tpFields = document.getElementById("tpFieldsEdit");
        let newField = document.createElement("div");
        newField.classList.add("input-group", "mb-2");
        newField.innerHTML = `
            <input type="text" name="nama_tp[]" class="form-control" placeholder="Nama Tujuan Pembelajaran">
            <button type="button" class="btn btn-danger" onclick="removeTpField(this)">
                <i class="bi bi-trash"></i>
            </button>
        `;
        tpFields.appendChild(newField);
    }

    function removeTpField(button) {
        button.parentElement.remove();
    }
</script>

</body>
</html>
@endsection
