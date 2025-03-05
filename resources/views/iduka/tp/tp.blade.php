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
        .custom-checkbox {
        appearance: none;
        width: 18px;
        height: 18px;
        border: 2px solid #ccc;
        border-radius: 4px;
        background-color: white;
        cursor: not-allowed;
        display: inline-block;
        position: relative;
    }

    /* Warna hijau jika checkbox tercentang */
    .custom-checkbox:checked {
        background-color: #28a745; /* Warna hijau */
        border-color: #28a745;
    }

    /* Tambahkan centang */
    .custom-checkbox:checked::after {
        content: '\2713'; /* Unicode untuk tanda centang ✓ */
        font-size: 14px;
        color: white;
        font-weight: bold;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
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
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#searchModal">
                                        <i class="bi bi-search"></i>
                                        <span class="d-none d-md-inline">Search</span>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahTpModal">
                                        <i class="bi bi-plus-lg"></i> <span class="d-none d-md-inline">Tambah TP</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach($idukaAtps->groupBy('konkes_id') as $konkes_id => $konke_items)
                    <div class="card card-content mt-3">
                        <div class="card-header">
                            <b>{{ $konke_items->first()->konke->name_konke }}</b> <!-- Menampilkan Nama Konke -->
                        </div>
                        <div class="card-body">
                            @foreach($konke_items->groupBy('cp.cp') as $cp_name => $items)
                            <div class="mb-3">
                                <b>{{ $loop->iteration }}. {{ $cp_name }}</b>
                                
                                    @foreach($items as $item)
                                   
                                        <div class="d-flex justify-content-between align-items-center ms-3">
                                        <span><b>{{ $item->atp->kode_atp }}</b> {{ $item->atp->atp }}</span>
                                            <input type="checkbox"
                                                name="tp_check[]"
                                                value="{{ $item->atp->id }}"
                                                class="tp-check custom-checkbox"
                                                {{ $item->is_selected ? 'checked' : '' }}
                                                disabled>
                                        </div>
                                    
                                    @endforeach

                               
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahTpModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah dan Edit Tujuan Pembelajaran Iduka</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('iduka_atp.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="iduka_id" id="iduka_id" value="{{ $iduka->id ?? '' }}"><input type="hidden" name="iduka_id" id="iduka_id" value="{{ auth()->user()->iduka_id }}">
                    <input type="hidden" name="konkes_id" id="konkes_id">

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
                                    <tr>
                                        <td colspan='2' class='text-center text-muted'>Silakan pilih kompetensi keahlian</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("checkAllTambah").addEventListener("click", function() {
            document.querySelectorAll(".tp-check").forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        document.querySelectorAll(".jurusan-btn").forEach(button => {
            button.addEventListener("click", function(event) {
                event.preventDefault();
                const konkes_id = this.getAttribute("data-konkes-id");
                document.getElementById("konkes_id").value = konkes_id;

               
                const tpTambahBody = document.getElementById("tp-tambah-body");

                tpTambahBody.innerHTML = "<tr><td colspan='2' class='text-center text-muted'>Loading...</td></tr>";

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
                                <td style='padding-left: 20px;'><b>${atp.kode_atp}</b> ${atp.atp}</td>
                                <td class="text-end">
                                    <input type='checkbox' class='tp-check' 
                                           name='tp_check[]' value='${atp.id}' 
                                           ${atp.is_selected ? 'checked' : ''}>
                                </td>
                            </tr>`;
                            });
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching data:", error);
                        tpTambahBody.innerHTML = "<tr><td colspan='2' class='text-danger'>Gagal memuat data.</td></tr>";
                    });
            });
        });
    });
</script>

</html>
@endsection