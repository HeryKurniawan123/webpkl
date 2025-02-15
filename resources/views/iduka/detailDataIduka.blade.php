@extends('layout.main')
@section('content')

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Detail Iduka</title>
        <style>
            .table td {
                vertical-align: middle; 
            }
            .table td:first-child {
                width: 40%; 
                text-align: left;
            }
            .table td:nth-child(2) {
                width: 1%; 
                text-align: right;
            }
            .table td:last-child {
                width: 55%; 
                text-align: left;
            }
            .card-header {
                max-width: 100%; 
                padding: 25px 20px 10px 20px; 
                border-radius: 8px 8px 0 0; 
            }

            .btn-back {
                background-color: #7e7dfb;
                color: white;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                font-size: 16px;
                cursor: pointer;
                transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out, background-color 0.2s ease-in-out;
            }

            .btn-back:hover {
                background-color: #7e7dfb;
                color: white;
                transform: translateY(-3px);
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.25); 
            }

            .btn-back:active {
                color: white;
                background-color: #6b6bfa !important; 
                transform: translateY( 3px); 
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
            }

        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="content-wrappe">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="card-header" style="background-color: #7e7dfb">
                            <h5 style="color: white;">Detail data #Iduka yang dipilih</h5>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-end mt-0 mb-2">
                                    <button type="button" class="btn btn-back shadow-sm" data-bs-toggle="modal" data-bs-target="#editIdukaModal">
                                        Edit Data
                                    </button>
                                </div>
                                <table class="table table-striped">
                                    <tr>
                                        <td>Nama IDUKA</td>
                                        <td> : </td>
                                        <td>Contoh</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Lengkap IDUKA</td>
                                        <td> : </td>
                                        <td>Contoh</td>
                                    </tr>
                                    <tr>
                                        <td>Kode Pos</td>
                                        <td> : </td>
                                        <td>Contoh</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Telepon IDUKA</td>
                                        <td> : </td>
                                        <td>Contoh</td>
                                    </tr>
                                    <tr>
                                        <td>Email IDUKA</td>
                                        <td> : </td>
                                        <td>Contoh</td>
                                    </tr>
                                    <tr>
                                        <td>Password</td>
                                        <td> : </td>
                                        <td>Contoh</td>
                                    </tr>
                                    <tr>
                                        <td>Bidang Idustri</td>
                                        <td> : </td>
                                        <td>Contoh</td>
                                    </tr>
                                    <tr>
                                        <td>Kerjasama</td>
                                        <td> : </td>
                                        <td>Contoh</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Kuota PKL</td>
                                        <td> : </td>
                                        <td>Contoh</td>
                                    </tr>
                                </table>
                                <div class="d-flex justify-content mt-3 mb-2">
                                    <a href="{{ route('data.iduka')}}" class="btn btn-back shadow-sm">
                                        Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- edit iduka --}}
        <div class="modal fade" id="editIdukaModal" tabindex="-1" aria-labelledby="editIdukaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="editIdukaModalLabel">Form Edit Data #id_iduka</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Nama Iduka</label>
                        <input type="text" class="form-control" id="" name="" placeholder="Masukkan Nama Iduka" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Alamat Lengkap</label>
                        <input type="text" class="form-control" id="" name="" placeholder="Masukkan Alamat Lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Kode Pos</label>
                        <input type="text" class="form-control" id="" name="" placeholder="Masukkan Kode Pos" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Nomor Telepon (Kantor / Perusahaan)</label>
                        <input type="number" class="form-control" id="" name="" placeholder="Masukkan Nomor Telepon" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Email</label>
                        <input type="email" class="form-control" id="" name="" placeholder="Masukkan Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Password</label>
                        <input type="text" class="form-control" id="" name="" placeholder="Masukkan Password" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Bidang Industri</label>
                        <input type="text" class="form-control" id="" name="" placeholder="Masukkan Bidang Industri" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kerjasama</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="" id="" value="" required>
                                    <label class="form-check-label" for="">Sinkronisasi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="" id="guru_tamu" value="Guru Tamu">
                                    <label class="form-check-label" for="guru_tamu">Guru Tamu</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="" id="magang" value="Magang / Pelatihan">
                                    <label class="form-check-label" for="magang">Magang / Pelatihan</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="" id="pkl" value="PKL">
                                    <label class="form-check-label" for="pkl">PKL</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="" id="" value="">
                                    <label class="form-check-label" for="">Sertifikasi</label>
                                </div>
                            </div>
                    
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="" id="" value="">
                                    <label class="form-check-label" for="">Tefa</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="" id="" value="">
                                    <label class="form-check-label" for="">Serapan</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="" id="" value="">
                                    <label class="form-check-label" for="">Beasiswa</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="" id="" value="">
                                    <label class="form-check-label" for="">PBL</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="" id="" value="">
                                    <label class="form-check-label" for="">Lainnya</label>
                                </div>
                            </div>
                        </div>
                    </div> 
                    {{-- jika mencet lainnya muncul ini --}}
                    {{-- <div class="mb-3">
                        <label for="" class="form-label">Kerjasama (Lainnya)</label>
                        <input type="number" class="form-control" id="" name="" placeholder="Masukkan Kerjasama" required>
                    </div> --}}
                    <div class="mb-3">
                        <label for="" class="form-label">Jumlah Kuota PKL</label>
                        <input type="number" class="form-control" id="" name="" placeholder="Masukkan Kuota PKL" required>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
              </div>
            </div>
        </div>
    </body>
</html>

@endsection