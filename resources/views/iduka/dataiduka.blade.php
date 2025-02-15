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

        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="d-flex justify-content-end mt-0 mb-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahIdukaModal">
                                Tambah Iduka 
                            </button>
                        </div>
                        <div class="col-md-12 mt-3">
                            {{-- kode kalo data iduka gaada--}}
                            {{-- @if ($iduka->isEmpty()) 
                                <div class="alert alert-warning">
                                    Belum ada data Iduka yang tersedia.
                                </div>
                            @endif --}}
                            <div class="card mb-3 shadow-sm card-hover" style="padding: 30px; border-radius: 10px;"> 
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="mb-0" style="font-size: 18px">Nama Iduka</div>
                                        <div class="">Alamat Iduka</div>
                                    </div>
                                    <a href="{{ route('detail.iduka')}}" class="btn btn-hover rounded-pill">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- tambah data idukaa --}}
        <div class="modal fade" id="tambahIdukaModal" tabindex="-1" aria-labelledby="tambahIdukaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="tambahIdukaModalLabel">Form Tambah Data Industri Dunia Kerja</h1>
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
                  <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
              </div>
            </div>
          </div>
    </body>
    </html>
@endsection