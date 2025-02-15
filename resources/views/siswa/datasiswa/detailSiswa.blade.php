@extends('layout.main')
@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Detail Data Nama Siswa</title>
        <style>
            .nav-tabs .nav-link.active {
                background-color: #9f9fff6c; 
            }
        
            .nav-tabs .nav-link {
                background-color: white;
                color: white;
                border: 1px solid #white;
        
            }
        
            .nav-tabs .nav-link:hover {
                background-color: 9f9fff;
                color: white;
            }
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
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="data-pribadi-tab" data-bs-toggle="tab" href="#dataPribadi" role="tab">
                                                Data Pribadi
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="data-orangtua-tab" data-bs-toggle="tab" href="#dataOrangTua" role="tab">
                                                Data Orang Tua
                                            </a>
                                        </li>
                                    </ul>
                            
                                    <div class="dropdown">
                                        <button class="btn btn-back dropdown-toggle" 
                                            style="background-color: #7e7dfb; color: white; padding: 6px 12px;" 
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Edit Data
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="min-width: 150px; padding: 5px;">
                                            <li>
                                                <button type="button" class="dropdown-item py-1" data-bs-toggle="modal" data-bs-target="#editSiswaModal">
                                                    Edit Data Pribadi
                                                </button>
                                                <button class="dropdown-item  py-1" data-bs-toggle="modal" data-bs-target="#editOrtuModal" type="button">
                                                    Edit Data Orang Tua
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
        
                                <div class="card-body">                                 
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="dataPribadi" role="tabpanel">
                                            <h4>Data Pribadi</h4>
                                            <table class="table table-striped">
                                                <tr>
                                                    <td>Nama Siswa</td>
                                                    <td>:</td>
                                                    <td>Malva Riski Nur Aulia</td>
                                                </tr>
                                                <tr>
                                                    <td>NIS</td>
                                                    <td>:</td>
                                                    <td>Contoh</td>
                                                </tr>
                                                <tr>
                                                    <td>Konsentrasi Keahlian</td>
                                                    <td>:</td>
                                                    <td>Contoh</td>
                                                </tr>
                                                <tr>
                                                    <td>Kelas</td>
                                                    <td>:</td>
                                                    <td>Contoh</td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td>:</td>
                                                    <td>Contoh</td>
                                                </tr>
                                                <tr>
                                                    <td>Password</td>
                                                    <td>:</td>
                                                    <td>******</td>
                                                </tr>
                                            </table>
                                        </div>
        
                                        <div class="tab-pane fade" id="dataOrangTua" role="tabpanel">
                                            <h5>Data Orang Tua</h5>
                                            <table class="table table-striped">
                                                <tr>
                                                    <td>Nama Ayah</td>
                                                    <td>:</td>
                                                    <td>Contoh</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Ibu</td>
                                                    <td>:</td>
                                                    <td>Contoh</td>
                                                </tr>
                                                <tr>
                                                    <td>NIK</td>
                                                    <td>:</td>
                                                    <td>Contoh</td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat</td>
                                                    <td>:</td>
                                                    <td>Contoh</td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td>:</td>
                                                    <td>Contoh</td>
                                                </tr>
                                                <tr>
                                                    <td>No Telepon</td>
                                                    <td>:</td>
                                                    <td>Contoh</td>
                                                </tr>
                                            </table>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content mt-3 mb-2">
                                            <a href="{{ route('data.siswa')}}" class="btn btn-back shadow-sm">
                                                Kembali
                                            </a>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('siswa.datasiswa.editSiswa')
        @include('orangtua.dataOrtu.editOrtu')
    </body>
    </html>
@endsection