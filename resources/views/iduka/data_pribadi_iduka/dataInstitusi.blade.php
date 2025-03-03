@extends('layout.main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Institusi/Perusahaan Tempat PKL</title>
    <style>
        table{
            width: 100%;
        }
        td:first-child{
            width: 5px;
            white-space: nowrap;
        }
        td:nth-child(2){
            width: 400px;
        }
        td:nth-child(3){
            width: 5px;
        }

        td:nth-child(2) span {
            display: block;
            margin-left: 20px;
        }

        .isi-keterangan table {
            width: 100%;
        }
        .isi-keterangan table td {
            padding: 6px;
        }
        .isi-keterangan table td:first-child {
            width: 5px;
        }

        .table-responsive {
            overflow-x: auto;
        }
        .table {
            min-width: 100%;
        }
        @media (max-width: 576px) {
            .modal-dialog {
                max-width: 95%;
            }

            table {
                font-size: 14px;
                white-space: nowrap;
            }

            td, th {
                padding: 8px;
            }

            h4 {
                font-size: 16px;
            }
        }
        @media (max-width: 576px) {
            .mb-3 {
                flex-direction: column;
            }

            .mb-3 .col-md-6 {
                width: 100%;
            }

            .mb-3 .col-md-6:last-child {
                margin-left: 0;
            }
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
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Data Institusi / Perusahaan Tempat PKL</h4>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editDataModal">
                                    Edit
                                  </button>
                            </div>
                        </div>
                    </div>                    
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-3">
                                    <tr>
                                        <td>1.</td>
                                        <td>Nama Institusi / DUDI</td>
                                        <td>:</td>
                                        <td>INOVINDO</td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>Alamat Institusi / DUDI</td>
                                        <td>:</td>
                                        <td>BANDUNG</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="3"></td>
                                        <td rowspan="3"></td>
                                        <td rowspan="3"></td>
                                        <td>Kec.
                                            <br>Kab/Kota*)
                                            <br>Prov.
                                        </td>
                                    </tr>
                                    <tr>
                                        {{-- kosongkan --}}
                                    </tr>
                                    <tr>
                                        {{-- kosongkan --}}
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td>Bidang Usaja / Kerja</td>
                                        <td>:</td>
                                        <td>Pembuatan Website</td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td>Nomor Telepon / HP Perusahaan</td>
                                        <td>:</td>
                                        <td>082317340473</td>
                                    </tr>
                                    <tr>
                                        <td>5.</td>
                                        <td colspan="3">Yang akan menandatangani sertifikat PKL</td>
                                    </tr>
                                    {{-- pemimpin --}}
                                    <tr>
                                        <td></td>
                                        <td colspan="3"><b>A. Kepala / Pimpinan Institusi / Perusahaan</b></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><span>a) Nama Lengkap</span></td>
                                        <td>:</td>
                                        <td>MALVA RISKINA + GELAR</td> <!--nu kapital brarti kapital hurufna-->
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><span>b) Nomor Induk Pegawai / Nomor Induk Karyawan</span></td>
                                        <td>:</td>
                                        <td>222310275 (opsional)</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><span>c) Jabatan</span></td>
                                        <td>:</td>
                                        <td>SISWA</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><span>d) No Hp / Telepon</span></td>
                                        <td>:</td>
                                        <td>089551301707</td>
                                    </tr>
                                    {{-- pembimbing --}}
                                    <tr>
                                        <td></td>
                                        <td colspan="3"><b>B. Pembimbing Institusi / Perusahaan</b></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><span>a) Nama Lengkap</span></td>
                                        <td>:</td>
                                        <td>MALVA RISKINA + GELAR</td> <!--nu kapital brarti kapital hurufna-->
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><span>b) Nomor Induk Pegawai / Nomor Induk Karyawan</span></td>
                                        <td>:</td>
                                        <td>222310275 (opsional)</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><span>d) No Hp / Telepon</span></td>
                                        <td>:</td>
                                        <td>089551301707</td>
                                    </tr>
                                    
                                    <tr>
                                        <td>6.</td>
                                        <td>Apakah institusi / perusahaan akan menerbitkan surat keterangan atau sertifikat di cetak oleh perusahaan atau dibantu pihak sekolah?</td>
                                        <td></td>
                                        <td>
                                            <input type="radio"> Cetak oleh perusahaan
                                            <br>
                                            <input type="radio"> Dibantu pihak sekolah
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7.</td>
                                        <td>Apakah di institusi / perusahaan ada SOP (Standar Operasional Prosedur) / Aturan Kerja / Tata Tertib?</td>
                                        <td></td>
                                        <td>
                                            <input type="radio"> Ya
                                            <br>
                                            <input type="radio"> Tidak
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>8.</td>
                                        <td>Apakah di institusi / perusahaan menerapkan K3LH (kesehatan, keselamatan kerja, dan lingkungan hidup)?</td>
                                        <td></td>
                                        <td>
                                            <input type="radio"> Ya
                                            <br>
                                            <input type="radio"> Tidak
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="keterangan">
                                <span>Keterangan :</span>
                                <div class="isi-keterangan">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <tr>
                                                <td>1.</td>
                                                <td>Seluruh data institusi / perusahaan tempat PKL diinput melalui link <a href="/https://bit.ly/DataDUDIKA2024">https://bit.ly/DataDUDIKA2024</a></td>
                                            </tr>
                                            <tr>
                                                <td>2.</td>
                                                <td>Jika cetak sertifikat atau surat keterangan PKL akan dibantu oleh pihak sekolah, mohon untuk dapat mengirimkan Logo dan Kop surat perusahaan untuk kami cantumkan di berkas Sertifikat.
                                                    <br> <i class="bi bi-arrow-right-short"></i><i>Jika logo dalam bentuk file, bisa di transfer via whatsapp, email, atau flashdisc murid / guru yang menerima berkas ini.</i>
                                                    <br> <i class="bi bi-arrow-right-short"></i><i>Jika terdapat di web, mohon diisikan alamat web nya.</i>
                                                    <br style="margin-left: 20px; display: block;"><span><i>Alamat web: ....</i></span>
                                                    <i class="bi bi-arrow-right-short"></i><i>Jika logo terdapat di brosur, pamflet atau bon, mohon ijin untuk kami bawa atau di kami foto sebagai contoh untuk kami desain ulang.</i>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- edit data institusi --}}
    <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="editDataModalLabel">Form Edit Data Institusi / Perusahaan Tempat PKL</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="" class="form-label">Nama Institusi / DUDI <i>(Dengan huruf kapital)</i></label>
                    <input type="text" class="form-control" name="" value="" >
                </div>
                
                <div class="mb-3">
                    <label for="" class="form-label">Alamat Institusi / DUDI <i>(Dengan huruf kapital)</i></label>
                    <input type="text" class="form-control" name="" value="" >
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Bidang Usaha / Kerja</label>
                    <input type="text" class="form-control" name="" value="" >
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Nomor Telepon / HP Perusahaan</label>
                    <input type="text" class="form-control" name="" value="" >
                </div>

                <h5>A. Kepala / Pimpinan Institusi Perusahaan</h5>

                <div class="mb-3">
                    <label for="" class="form-label">Nama Lengkap <i>(Dengan huruf kapital)</i></label>
                    <input type="text" class="form-control" name="" value="" >
                </div>
                
                <div class="mb-3">
                    <label for="" class="form-label">Nomor Induk Pegawai / Nomor Induk Karyawan</label>
                    <input type="text" class="form-control" name="" value="" >
                </div>
                
                <div class="mb-3">
                    <label for="" class="form-label">Jabatan <i>(Dengan huruf kapital)</i></label>
                    <input type="text" class="form-control" name="" value="" >
                </div>
                
                <div class="mb-3">
                    <label for="" class="form-label">No HP</label>
                    <input type="text" class="form-control" name="" value="" >
                </div>
                

                <h5> B. Pembimbing Institusi / Perusahaan</h5>

                <div class="mb-3">
                    <label for="" class="form-label">Nama Lengkap <i>(Dengan huruf kapital)</i></label>
                    <input type="text" class="form-control" name="" value="" >
                </div>
                
                <div class="mb-3">
                    <label for="" class="form-label">Nomor Induk Pegawai / Nomor Induk Karyawan</label>
                    <input type="text" class="form-control" name="" value="" >
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">No HP</label>
                    <input type="text" class="form-control" name="" value="" >
                </div>

                <div class="mb-3 d-flex align-items-center border-bottom pb-3">
                    <div class="col-md-6">
                        <p class="mb-0">
                            Apakah institusi / perusahaan akan menerbitkan surat keterangan atau sertifikat dicetak oleh perusahaan atau dibantu pihak sekolah?
                        </p>
                    </div>
                    <div class="col-md-6 d-flex flex-column ms-4">
                        <label><input type="radio" name="sertifikat1"> Cetak oleh perusahaan</label>
                        <label><input type="radio" name="sertifikat1"> Dibantu pihak sekolah</label>
                    </div>
                </div>
                
                <div class="mb-3 d-flex align-items-center border-bottom pb-3">
                    <div class="col-md-6">
                        <p class="mb-0">
                            Apakah di institusi / perusahaan ada SOP (Standar Operasional Prosedur) / Aturan Kerja / Tata Tertib?
                        </p>
                    </div>
                    <div class="col-md-6 d-flex flex-column ms-4">
                        <label><input type="radio" name="sop"> Ya</label>
                        <label><input type="radio" name="sop"> Tidak</label>
                    </div>
                </div>
                
                <div class="mb-3 d-flex align-items-center">
                    <div class="col-md-6">
                        <p class="mb-0">
                            Apakah di institusi / perusahaan menerapkan K3LH (kesehatan, keselamatan kerja, dan lingkungan hidup)?
                        </p>
                    </div>
                    <div class="col-md-6 d-flex flex-column ms-4">
                        <label><input type="radio" name="k3lh"> Ya</label>
                        <label><input type="radio" name="k3lh"> Tidak</label>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <button type="button" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </div>
      </div>
</body>
</html>
@endsection