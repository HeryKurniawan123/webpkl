@extends('layout.main')
@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Dashbooard</title>
    </head>
    <body>
        <div class="container-fluid"><br>
            <div class="content-wrapper">
              <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                  <div class="col-lg-8 mb-4 order-0">
                    <div class="card">
                      <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                          <div class="card-body">
                            <h5 class="card-title text-primary">Halo {{ Auth::user()->name }}! 🎉</h5>
                            <p class="mb-4">
                             Data kamu belum terisi sepenuhnya nih. Ayo isi terlebih dahulu!
                            </p>
                            @if(auth()->user()->role == 'siswa')
                                <a href="{{ route('detail.siswa')}}" class="btn btn-sm btn-outline-primary">Lengkapi Data </a>
                            @endif
                            @if(in_array(auth()->user()->role, ['hubin', 'guru', 'ppkl', 'psekolah', 'orangtua', 'kaprog', 'iduka', 'persuratan']))
                                <p>button "Lengkapi Data" baru ada di akun siswa</p>
                            @endif
                          </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                          <div class="card-body pb-0 px-0 px-md-4">
                            <img
                              src="{{ asset('snet/assets/img/illustrations/man-with-laptop-light.png') }}"
                              height="140"
                              alt="View Badge User"
                              data-app-dark-img="illustrations/man-with-laptop-dark.png')}}"
                              data-app-light-img="illustrations/man-with-laptop-light.png')}}"
                            />
                          </div>
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