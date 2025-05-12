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
                  <p class="mb-4">Data kamu belum terisi sepenuhnya nih. Ayo isi terlebih dahulu!</p>

                  @if(auth()->user()->role == 'siswa')
                  <a href="{{ route('detail.siswa') }}" class="btn btn-sm btn-outline-primary">Lengkapi Data</a>
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
                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      @if(auth()->user()->role == 'siswa')

      {{-- BUTTON PENGAJUAN --}}
      <div class="row mt-3">
        <div class="col-lg-12 d-flex justify-content-end mb-4">
          <div class="btn-group me-auto">
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              Buat Pengajuan
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
              <li>
                @if($sudahAjukan)
                @if($statusAjukan === 'proses')
                <a href="#" class="dropdown-item" onclick="Swal.fire({
                      icon: 'warning',
                      title: 'Pengajuan Sedang Diproses',
                      text: 'Kamu sudah mengajukan usulan PKL dan sedang diproses.',
                      showConfirmButton: true,
                      customClass: { popup: 'animate__animated animate__bounce' }
                  })">Buat Usulan</a>
                @elseif($statusAjukan === 'diterima')
                <a href="#" class="dropdown-item" onclick="Swal.fire({
                      icon: 'info',
                      title: 'Tidak dapat mengajukan!',
                      text: 'Kamu sudah mengusulkan dan usulan telah diterima.',
                      showConfirmButton: true,
                      customClass: { popup: 'animate__animated animate__fadeInDown' }
                  })">Buat Usulan</a>
                @else
                <a href="#" class="dropdown-item" onclick="Swal.fire({
                      icon: 'info',
                      title: 'Pengajuan Tidak Diterima',
                      text: 'Pengajuan sedang diproses atau telah diterima.',
                      showConfirmButton: true,
                      customClass: { popup: 'animate__animated animate__fadeIn' }
                  })">Buat Usulan</a>
                @endif
                @else
                <a href="{{ route('iduka.usulan') }}" class="dropdown-item">Buat Usulan</a>
                @endif
              </li>

              <li>
                @if($sudahDiterima)
                <a href="#" class="dropdown-item" onclick="Swal.fire({
                    icon: 'error',
                    title: 'Sudah Diterima',
                    text: 'Kamu sudah diterima di tempat PKL. Tidak bisa mengajukan lagi.',
                    showConfirmButton: true,
                    customClass: { popup: 'animate__animated animate__shakeX' }
                })">Usulan Baru</a>
                @endif
              </li>
            </ul>
          </div>
        </div>
      </div>

      {{-- RIWAYAT USULAN --}}
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
            <h5>Riwayat Usulan</h5>
            <div class="table-responsive">
              <table class="table table-hover" style="text-align: center">
                <thead>
                  <tr>
                    <td>#</td>
                    <td>Nama Institusi</td>
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

                      @if($usulan->status == 'diterima' || $usulan->status == 'proses')
                      <form action="{{ route('siswa.pengajuan.ajukanPembatalan', $usulan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin mengajukan pembatalan?')">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm">
                          <i class="bi bi-x-circle"></i> Batal
                        </button>
                      </form>
                      @endif
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" style="text-align: center">Tidak ada data yang harus ditampilkan.</td>
                  </tr>
                  @endforelse

                  @forelse($usulanPkl as $index => $usul)
                  <tr>
                    <td>{{ $index + 2 }}.</td>
                    <td>{{ $usul->iduka->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($usul->created_at)->format('d/m/Y') }}</td>
                    <td>
                      @if($usul->status == 'proses')
                      <span class="badge bg-warning">Menunggu Verifikasi</span>
                      @elseif($usul->status == 'diterima')
                      <span class="badge bg-success">Usulan Diterima</span>
                      @elseif($usul->status == 'menunggu')
                      <span class="badge bg-secondary">Menunggu Pembatalan</span>
                      @elseif($usul->status == 'batal')
                      <span class="badge bg-secondary">Pengajuan Dibatalkan</span>
                      @else
                      <span class="badge bg-danger">Ditolak</span>
                      @endif
                    </td>
                    <td>
                      <div class="d-flex gap-2 justify-content-center">
                      <a href="{{ route('detail.usulan', $usul->id) }}" class="btn btn-info btn-sm d-flex align-items-center justify-content-center mt-3" style="width: 40px; height: 25px;">
                        <i class="bi bi-eye"></i>
                      </a>
                      @if($usul->status == 'diterima')
                      <a href="{{ route('usulan.pdf', $usul->id) }}" class="btn btn-info btn-sm d-flex align-items-center justify-content-center mt-3" style="width: 40px; height: 25px;">
                        <i class="bi bi-filetype-pdf"></i>
                      </a>
                      @endif
                      @if($usul->status == 'diterima' || $usul->status == 'proses')
                      <form action="{{ route('siswa.pengajuan.ajukanPembatalan', $usul->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin mengajukan pembatalan?')">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center mt-3" style="width: 40px; height: 25px;">
                          <i class="bi bi-x-circle"></i>
                        </button>
                      </form>
                      @endif
                    </div>
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
      </div>

      {{-- RIWAYAT PENGAJUAN --}}
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="card-body">
            <h5>Riwayat Pengajuan</h5>
            <div class="table-responsive">
              <table class="table table-hover text-center">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nama Institusi</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($pengajuanSiswa as $index => $pengajuan)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pengajuan->iduka->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d/m/Y') }}</td>
                    <td>
                      @if($pengajuan->status == 'proses')
                      <span class="badge bg-warning">Menunggu Verifikasi</span>
                      @elseif($pengajuan->status == 'diterima')
                      <span class="badge bg-success">Diterima</span>
                      @else
                      <span class="badge bg-danger">Ditolak</span>
                      @endif
                    </td>
                    <td>
                      <a href="{{ route('pengajuan.detail', $pengajuan->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5">Tidak ada data yang harus ditampilkan.</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection

{{-- SweetAlert --}}
@if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    showConfirmButton: false,
    timer: 2000,
    customClass: {
      popup: 'animate__animated animate__fadeInDown'
    }
  });
</script>
@endif

@if(session('error'))
<script>
  Swal.fire({
    icon: 'error',
    title: 'Oops!',
    text: "{{ session('error') }}",
    showConfirmButton: false,
    timer: 2500,
    customClass: {
      popup: 'animate__animated animate__shakeX'
    }
  });
</script>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />