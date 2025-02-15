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
                width: 5%; 
                text-align: center;
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
    </body>
</html>

@endsection