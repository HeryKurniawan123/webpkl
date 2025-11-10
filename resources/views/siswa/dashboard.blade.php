@extends('layout.main')

@section('content')
    <div class="container-fluid"><br>
    @if(isset($statusPindahPkl))
    @if($statusPindahPkl->status == 'menunggu')
        <div class="alert alert-warning alert-dismissible fade show mt-3 shadow-sm border-0" role="alert"
             style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-left: 4px solid #f39c12;">
            <div class="d-flex align-items-start">
                <div class="flex-shrink-0">
                    <div class="alert-icon-wrapper waiting-pulse" 
                         style="width: 40px; height: 40px; background: #f39c12; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-hourglass-split text-white fs-5"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 class="alert-heading mb-1" style="color: #856404;">
                            <span class="waiting-dots">Menunggu Verifikasi</span>
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <p class="mb-0 text-dark" style="font-size: 0.9rem;">
                        Pengajuan pindah PKL Anda sedang dalam proses verifikasi. 
                        Silakan hubungi Kaprog jurusan Anda untuk mempercepat proses.
                    </p>
                </div>
            </div>
        </div>

    @elseif($statusPindahPkl->status == 'menunggu_surat')
        <div class="alert alert-info alert-dismissible fade show mt-3 shadow-sm border-0" role="alert"
             style="background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%); border-left: 4px solid #17a2b8;">
            <div class="d-flex align-items-start">
                <div class="flex-shrink-0">
                    <div class="alert-icon-wrapper waiting-pulse" 
                         style="width: 40px; height: 40px; background: #17a2b8; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-printer text-white fs-5"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 class="alert-heading mb-1" style="color: #0c5460;">
                            <span class="waiting-dots">Menunggu Surat Dicetak</span>
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <p class="mb-0 text-dark" style="font-size: 0.9rem;">
                        Pengajuan pindah PKL anda telah diterima, selanjutnya menunggu surat dicetak.
                    </p>
                </div>
            </div>
        </div>

    @elseif($statusPindahPkl->status == 'siap_kirim')
        <div class="alert alert-primary alert-dismissible fade show mt-3 shadow-sm border-0" role="alert"
             style="background: linear-gradient(135deg, #cce7ff 0%, #b3d9ff 100%); border-left: 4px solid #3498db;">
            <div class="d-flex align-items-start">
                <div class="flex-shrink-0">
                    <div class="alert-icon-wrapper waiting-pulse" 
                         style="width: 40px; height: 40px; background: #3498db; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-send-check text-white fs-5"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 class="alert-heading mb-1" style="color: #004085;">
                            <span class="waiting-dots">Surat telah dicetak</span>
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <p class="mb-0 text-dark" style="font-size: 0.9rem;">
                        Surat pengajuan pindah tempat PKL kamu telah dicetak dan telah dikirim ke IDUKA, silahkan tunggu verifikasi dari IDUKA.
                    </p>
                </div>
            </div>
        </div>

    @elseif($statusPindahPkl->status == 'diterima_iduka')
        <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm border-0" role="alert"
             style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border-left: 4px solid #28a745;">
            <div class="d-flex align-items-start">
                <div class="flex-shrink-0">
                    <div class="alert-icon-wrapper success-pulse" 
                         style="width: 40px; height: 40px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-check-circle text-white fs-5"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 class="alert-heading mb-1" style="color: #155724;">
                            <span>Pindah PKL Diterima</span>
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <p class="mb-0 text-dark" style="font-size: 0.9rem;">
                        Pengajuan pindah PKL anda telah diterima, silahkan buat pengajuan baru untuk mengajukan tempat PKL kamu.
                    </p>
                </div>
            </div>
        </div>

    @elseif($statusPindahPkl->status == 'ditolak_iduka')
        <div class="alert alert-danger alert-dismissible fade show mt-3 shadow-sm border-0" role="alert"
             style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border-left: 4px solid #dc3545;">
            <div class="d-flex align-items-start">
                <div class="flex-shrink-0">
                    <div class="alert-icon-wrapper error-pulse" 
                         style="width: 40px; height: 40px; background: #dc3545; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-x-circle text-white fs-5"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 class="alert-heading mb-1" style="color: #721c24;">
                            <span>Pindah PKL Ditolak</span>
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <p class="mb-0 text-dark" style="font-size: 0.9rem;">
                        Pengajuan pindah PKL anda ditolak, silahkan hubungi kaprog jurusan kamu atau iduka kamu untuk alasan lebih lanjut.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <style>
        .waiting-pulse {
            animation: waitingPulse 2s infinite ease-in-out;
        }
        
        .success-pulse {
            animation: successPulse 2s infinite ease-in-out;
        }
        
        .error-pulse {
            animation: errorPulse 2s infinite ease-in-out;
        }
        
        .waiting-dots::after {
            content: '';
            animation: waitingDots 1.5s infinite;
        }
        
        @keyframes waitingPulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(243, 156, 18, 0.7);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(243, 156, 18, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(243, 156, 18, 0);
            }
        }
        
        @keyframes successPulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
            }
        }
        
        @keyframes errorPulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }
        
        @keyframes waitingDots {
            0%, 20% { content: '.'; }
            40% { content: '..'; }
            60%, 100% { content: '...'; }
        }
    </style>
@endif
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="col-lg-12 mb-3 order-0">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-sm-7">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary d-flex align-items-center">
                                            Halo {{ Auth::user()->name }}!
                                            <i class="bi bi-fire text-danger ms-2"></i>
                                        </h5>
                                        <p class="mb-4 text-secondary">
                                            <i class="bi bi-person-badge-fill text-primary me-2"></i>
                                            Pembimbing Kamu
                                            <span class="fw-bold text-bold">
                                                {{ $user->pembimbing->nama ?? 'Belum ada pembimbing' }}
                                            </span>
                                        </p>

                                        <p class="mb-4">Data kamu belum terisi sepenuhnya nih. Ayo isi terlebih dahulu!
                                        </p>

                                        @if (auth()->user()->role == 'siswa')
                                            <a href="{{ route('siswa.data_pribadi.create') }}"
                                                class="btn btn-sm btn-outline-primary">Lengkapi Data</a>
                                        @endif

                                        @if (in_array(auth()->user()->role, ['hubin', 'guru', 'ppkl', 'psekolah', 'orangtua', 'kaprog', 'iduka', 'persuratan']))
                                            <p>Button "Lengkapi Data" baru ada di akun siswa</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-sm-5 text-center text-sm-left">
                                    <div class="card-body pb-0 px-0 px-md-4">
                                        <img src="{{ asset('snet/assets/img/illustrations/man-with-laptop-light.png') }}"
                                            height="140" alt="View Badge User"
                                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                            data-app-light-img="illustrations/man-with-laptop-light.png" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (auth()->user()->role == 'siswa')

                    {{-- BUTTON PENGAJUAN --}}
                    <div class="row mt-3">
                        <div class="col-lg-12 d-flex justify-content-end mb-4">
                            <div class="btn-group me-auto">
                                {{-- Tombol Buat Pengajuan --}}
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Buat Pengajuan
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        @php
                                            // Cek apakah ada pengajuan pindah diterima
                                            $bisaAjukan = (!$sudahAjukan || ($statusPindahPkl && $statusPindahPkl->status == 'diterima_iduka'));
                                        @endphp

                                        @if ($bisaAjukan)
                                            <a href="{{ route('iduka.usulan') }}" class="dropdown-item">Buat Pengajuan</a>
                                        @else
                                            @if ($statusAjukan === 'proses')
                                                <a href="#" class="dropdown-item" onclick="Swal.fire({
                                                    icon: 'warning',
                                                    title: 'Pengajuan Sedang Diproses',
                                                    text: 'Kamu sudah mengajukan tempat PKL dan sedang diproses.'
                                                })">Buat Pengajuan</a>
                                            @elseif($statusAjukan === 'diterima')
                                                <a href="#" class="dropdown-item" onclick="Swal.fire({
                                                    icon: 'info',
                                                    title: 'Tidak dapat mengajukan!',
                                                    text: 'Kamu sudah mengajukan dan pengajuan telah diterima, kecuali permintaan pindah tempat PKL anda sudah diterima.'
                                                })">Buat Pengajuan</a>
                                            @else
                                                <a href="#" class="dropdown-item" onclick="Swal.fire({
                                                    icon: 'info',
                                                    title: 'Pengajuan Tidak Diterima',
                                                    text: 'Pengajuan sedang diproses atau telah diterima.'
                                                })">Buat Pengajuan</a>
                                            @endif
                                        @endif
                                    </li>

                                    <li>
                                        @php
                                            // Cek apakah siswa sudah diterima di tempat PKL
                                            // dan pengajuan pindah terakhir tidak aktif / diterima
                                            $bisaPengajuanBaru = $sudahDiterima
                                                && (!isset($statusPindahPkl)
                                                    || !in_array($statusPindahPkl->status, ['menunggu', 'ditolak_iduka']))
                                                && (Auth::user()->iduka_id === null); // hanya jika iduka_id kosong
                                        @endphp
                                    </li>
                                </ul>
                            </div>

                            {{-- Pindah Tempat PKL --}}
                            @if ($sudahDiterima)
                                @php
                                    $pengajuanAktif = isset($statusPindahPkl) && in_array($statusPindahPkl->status, ['menunggu', 'menunggu_surat', 'diterima_iduka', 'siap_kirim', 'menunggu_konfirmasi_iduka']);
                                @endphp

                                @if(!$pengajuanAktif)
                                    <form action="{{ route('pindah-pkl.ajukan') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning ms-2"
        onclick="return confirmAjukanPindah()">
    <i class="bi bi-arrow-repeat me-1"></i> Pindah Tempat PKL
</button>
                                    </form>
                                @else
                                    <button type="button" class="btn btn-outline-secondary ms-2" onclick="Swal.fire({
                                        icon: 'info',
                                        title: 'Pengajuan Aktif',
                                        text: 'Kamu sudah memiliki pengajuan pindah tempat PKL yang aktif.',
                                        showConfirmButton: true,
                                        customClass: { popup: 'animate__animated animate__fadeIn' }
                                    })">
                                        <i class="bi bi-arrow-repeat me-1"></i> Pindah Tempat PKL
                                    </button>
                                @endif

                                <script>
                                    function confirmAjukanPindah() {
                                        Swal.fire({
                                            title: 'Konfirmasi',
                                            text: 'Yakin ingin mengajukan pindah tempat PKL?',
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonText: 'Ya, ajukan!',
                                            cancelButtonText: 'Batal'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                Swal.fire({
                                                    icon: 'info',
                                                    title: 'Pengajuan Dikirim!',
                                                    text: 'Kamu sudah mengajukan permintaan pindah tempat PKL. Tunggu verifikasi dari Kaprog.',
                                                    showConfirmButton: true
                                                }).then(() => {
                                                    document.querySelector('form[action="{{ route('pindah-pkl.ajukan') }}"]').submit();
                                                });
                                            }
                                        });
                                        return false;
                                    }
                                </script>
                            @else
                                <button type="button" class="btn btn-outline-secondary ms-2" onclick="Swal.fire({
                                    icon: 'info',
                                    title: 'Belum Bisa Pindah',
                                    text: 'Kamu hanya bisa mengajukan pindah jika sudah diterima di tempat PKL.',
                                    showConfirmButton: true,
                                    customClass: { popup: 'animate__animated animate__fadeIn' }
                                })">
                                    <i class="bi bi-arrow-repeat me-1"></i> Pindah Tempat PKL
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- RIWAYAT PINDAH PKL --}}
@if(isset($riwayatPindahPkl) && $riwayatPindahPkl->count() > 0)
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="card-body">
                <h5>Riwayat Permintaan Pindah Tempat PKL</h5>
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tempat PKL Lama</th>
                                <th>Tempat PKL Baru</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatPindahPkl as $index => $pindah)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pindah->idukaLama->nama ?? 'Tidak Diketahui' }}</td>
                                    <td>{{ $pindah->iduka_baru_nama }}</td> {{-- Gunakan accessor --}}
                                    <td>{{ \Carbon\Carbon::parse($pindah->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($pindah->status == 'menunggu')
                                            <span class="badge bg-warning">Menunggu Verifikasi</span>
                                        @elseif($pindah->status == 'diterima_iduka')
                                            <span class="badge bg-success">Diterima</span>
                                        @elseif($pindah->status == 'ditolak_iduka')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif($pindah->status == 'menunggu_surat')
                                            <span class="badge bg-info">Menunggu Surat</span>
                                        @elseif($pindah->status == 'siap_kirim')
                                            <span class="badge bg-info">Menunggu Iduka</span>
                                        @elseif($pindah->status == 'menunggu_konfirmasi_iduka')
                                            <span class="badge bg-info">Menunggu Konfirmasi IDUKA</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $pindah->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-sm"
                                                onclick="showDetailPindah({{ $pindah }})">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
                    {{-- RIWAYAT USULAN --}}
                    <div class="col-lg-12 mb-4 order-0">
                        <div class="card">
                            <div class="card-body">
                                <h5>Riwayat Pengajuan Tempat PKL</h5>
                                <div class="table-responsive">
                                    <table class="table table-hover" style="text-align: center">
                                        <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>Nama Institusi</td>
                                                <td>Tanggal Pengajuan</td>
                                                <td>Status</td>
                                                <td>Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($usulanSiswa as $index => $usulan)
                                                <tr>
                                                    <td>{{ $index + 1 }}.</td>
                                                    <td>{{ $usulan->nama }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($usulan->created_at)->format('d/m/Y') }}
                                                    </td>
                                                    <td>
                                                        @if ($usulan->status == 'proses')
                                                            <span class="badge bg-warning">Menunggu Verifikasi</span>
                                                        @elseif($usulan->status == 'diterima')
                                                            <span class="badge bg-success">Diterima</span>
                                                        @else
                                                            <span class="badge bg-danger">Ditolak</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('detail.usulan', $usulan->id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        @if ($usulan->status == 'diterima')
                                                            <a href="{{ route('usulan.pdf', $usulan->id) }}"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="bi bi-filetype-pdf"></i>
                                                            </a>
                                                        @endif

                                                        @if ($usulan->status == 'diterima' || $usulan->status == 'proses')
                                                            <form action="{{ route('siswa.pengajuan.ajukanPembatalan', $usulan->id) }}"
                                                                method="POST" class="d-inline"
                                                                onsubmit="return confirm('Yakin ingin mengajukan pembatalan?')">
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
                                                    <td colspan="5" style="text-align: center">Tidak ada data yang harus
                                                        ditampilkan.</td>
                                                </tr>
                                            @endforelse

                                            @forelse($usulanPkl as $index => $usul)
                                                <tr>
                                                    <td>{{ $index + 2 }}.</td>
                                                    <td>{{ $usul->iduka->nama }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($usul->created_at)->format('d/m/Y') }}
                                                    </td>
                                                    <td>
                                                        @if ($usul->status == 'proses')
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
                                                            <a href="{{ route('detail.usulan', $usul->id) }}"
                                                                class="btn btn-info btn-sm d-flex align-items-center justify-content-center mt-3"
                                                                style="width: 40px; height: 25px;">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            @if ($usul->status == 'diterima')
                                                                <a href="{{ route('usulan.pdf', $usul->id) }}"
                                                                    class="btn btn-info btn-sm d-flex align-items-center justify-content-center mt-3"
                                                                    style="width: 40px; height: 25px;">
                                                                    <i class="bi bi-filetype-pdf"></i>
                                                                </a>
                                                            @endif
                                                            @if ($usul->status == 'diterima' || $usul->status == 'proses')
                                                                <form
                                                                    action="{{ route('siswa.pengajuan.ajukanPembatalan', $usul->id) }}"
                                                                    method="POST" class="d-inline"
                                                                    onsubmit="return confirm('Yakin ingin mengajukan pembatalan?')">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-warning btn-sm d-flex align-items-center justify-content-center mt-3"
                                                                        style="width: 40px; height: 25px;">
                                                                        <i class="bi bi-x-circle"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" style="text-align: center">Tidak ada data yang harus
                                                        ditampilkan.</td>
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
                                <h5>Riwayat Pengajuan PKL</h5>
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
                                                    <td>{{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d/m/Y') }}
                                                    </td>
                                                    <td>
                                                        @if ($pengajuan->status == 'proses')
                                                            <span class="badge bg-warning">Menunggu Verifikasi</span>
                                                        @elseif($pengajuan->status == 'diterima')
                                                            <span class="badge bg-success">Diterima</span>
                                                        @else
                                                            <span class="badge bg-danger">Ditolak</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('pengajuan.detail', $pengajuan->id) }}"
                                                            class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
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
@if (session('success'))
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

@if (session('error'))
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

<script>
function showDetailPindah(pindah) {
    let statusText = '';
    switch(pindah.status) {
        case 'menunggu':
            statusText = 'Menunggu Verifikasi';
            break;
        case 'diterima_iduka':
            statusText = 'Diterima';
            break;
        case 'ditolak_iduka':
            statusText = 'Ditolak';
            break;
        case 'menunggu_surat':
            statusText = 'Menunggu Surat';
            break;
        case 'siap_kirim':
            statusText = 'Siap Dikirim';
            break;
        case 'menunggu_konfirmasi_iduka':
            statusText = 'Menunggu Konfirmasi IDUKA';
            break;
        default:
            statusText = pindah.status;
    }

    Swal.fire({
        title: 'Detail Pengajuan Pindah PKL',
        html: `
            <div class="text-start">
                <p><strong>Tempat PKL Lama:</strong> ${pindah.iduka_lama ? pindah.iduka_lama.nama : 'Tidak Diketahui'}</p>
                <p><strong>Tempat PKL Baru:</strong> ${pindah.iduka_baru ? pindah.iduka_baru.nama : 'Tidak Diketahui'}</p>
                <p><strong>Tanggal Pengajuan:</strong> ${new Date(pindah.created_at).toLocaleDateString('id-ID')}</p>
                <p><strong>Status:</strong> <span class="text-capitalize">${statusText}</span></p>
                ${pindah.alasan ? `<p><strong>Alasan:</strong> ${pindah.alasan}</p>` : ''}
                ${pindah.catatan ? `<p><strong>Catatan:</strong> ${pindah.catatan}</p>` : ''}
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Tutup'
    });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
