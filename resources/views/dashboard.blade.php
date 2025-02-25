@extends('layout.main')
@section('content')
<div class="container-fluid"><br>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="row">
        <div class="col-lg-12 mb-3 order-0">
          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-7">
                <div class="card-body">
                  <h5 class="card-title text-primary">Halo {{ Auth::user()->name }}! 🎉</h5>
                  <p class="mb-4">
                    Data kamu belum terisi sepenuhnya nih. Ayo isi terlebih dahulu!
                  </p>
                  @if(auth()->user()->role == 'siswa')
                  <a href="{{ route('detail.siswa')}}" class="btn btn-sm btn-outline-primary">
                    Lengkapi Data
                  </a>
                  @endif
                  @if(in_array(auth()->user()->role, ['hubin', 'guru', 'ppkl', 'psekolah', 'orangtua', 'kaprog', 'iduka', 'persuratan']))
                  <p>Button "Lengkapi Data" baru ada di akun siswa</p>
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
                    data-app-light-img="illustrations/man-with-laptop-light.png')}}" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @if(auth()->user()->role == 'siswa')
      <div class="row mt-3">
        <div class="col-lg-12 d-flex justify-content-end mb-4">
          <div class="btn-group me-auto">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              Buat Pengajuan
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
              <li>
                <a href="{{ route('usulan.index') }}" type="button" class="dropdown-item">
                  Buat Usulan
                </a>
              </li>
              <li>
                <a href="{{ route('data.iduka') }}" type="button" class="dropdown-item">
                  Buat Pengajuan
                </a>
                {{-- <button type="button" class="dropdown-item" >
                                            Buat Pengajuan
                                        </button> --}}
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
            <h5>Riwayat Usulan</h5>
            <table class="table table-hover" style="text-align: center">
              <thead>
                <tr>
                  <td>#</td>
                  <td>Nama Iduka</td>
                  <td>Tanggal Usulan</td>
                  <td>Status</td>
                  <td>Aksi</td>
                </tr>
              </thead>
              <tbody>
                @forelse($usulanSiswa as $index => $usulan)
                <tr>
                  <td>{{ $index + 1 }}.</td>
                  <td>{{ $usulan->nama }}</td>
                  <td>{{ \Carbon\Carbon::parse($usulan->created_at)->format('d/m/Y') }}</td>
                  <td>
                    @if($usulan->status == 'proses')
                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                    @elseif($usulan->status == 'diterima')
                    <span class="badge bg-success">Diterima</span>
                    @else
                    <span class="badge bg-danger">Ditolak</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{ route('detail.usulan', $usulan->id) }}" class="btn btn-info btn-sm">
                      <i class="bi bi-eye"></i>
                    </a>
                    @if($usulan->status == 'diterima')
                    <a href="{{ route('usulan.pdf', $usulan->id) }}" class="btn btn-danger btn-sm">
                      <i class="bi bi-filetype-pdf"></i>
                    </a>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" style="text-align: center">Tidak ada data yang harus ditampilkan.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
            <h5>Riwayat Pengajuan</h5>
            <table class="table table-hover" style="text-align: center">
              <thead>
                <tr>
                  <td>#</td>
                  <td>Nama Iduka</td>
                  <td>Tanggal Usulan</td>
                  <td>Status</td>
                  <td>Aksi</td>
                </tr>
              </thead>
              {{-- @if ($pengajuan->isEmpty())
                            <tr>
                              <td style="text-align: center" colspan="5">Tidak ada data yang harus ditampilkan.</td>
                            </tr>
                            @endif --}}
              <tbody>
                <tr>
                  <td>1.</td>
                  <td>Inovindo</td>
                  <td>23/02/25</td>
                  <td>
                    {{-- jika diterima --}}
                    <span class="badge bg-success">Diterima</span>
                    {{-- jika menunggu verifikasi --}}
                    {{-- <span class="badge bg-warning">Menunggu Verifikasi</span> --}}
                    {{-- jika ditolak --}}
                    {{-- <span class="badge bg-danger">Diterima</span> --}}
                  </td>
                  <td>
                    <a href="/surat-pengajuan/detail"
                      class="btn btn-info btn-sm">
                      <i class="bi bi-eye"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      @endif
    </div>
  </div>
</div>
@endsection