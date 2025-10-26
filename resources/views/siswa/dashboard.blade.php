@extends('layout.main')

@section('content')
    <div class="container-fluid"><br>
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                
                {{-- NOTIFIKASI STATUS PINDAH PKL --}}
                @if(isset($statusPindahPkl) && $statusPindahPkl)
                    <div class="alert 
                        @if($statusPindahPkl->status == 'menunggu') alert-warning
                        @elseif($statusPindahPkl->status == 'diterima') alert-success
                        @elseif($statusPindahPkl->status == 'ditolak') alert-danger
                        @else alert-info @endif
                    ">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Status Pengajuan Pindah Tempat PKL:</strong> 
                                <span class="text-capitalize">{{ $statusPindahPkl->status }}</span>
                                
                                @if($statusPindahPkl->status == 'diterima')
    <span class="ms-2">
        <a href="{{ route('pindah-pkl.download-surat', $statusPindahPkl->id) }}" class="btn btn-danger btn-sm">
    <i class="bi bi-filetype-pdf"></i>
</a>
    </span>
@endif

                            </div>
                            @if($statusPindahPkl->alasan)
                                <button class="btn btn-sm btn-outline-secondary" 
                                        onclick="Swal.fire({
                                            title: 'Alasan {{ ucfirst($statusPindahPkl->status) }}',
                                            text: '{{ $statusPindahPkl->alasan }}',
                                            icon: 'info',
                                            confirmButtonText: 'Tutup'
                                        })">
                                    <i class="bi bi-info-circle"></i> Lihat Alasan
                                </button>
                            @endif
                        </div>
                    </div>
                @endif

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
        $bisaAjukan = (!$sudahAjukan || ($statusPindahPkl && $statusPindahPkl->status == 'diterima'));
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
                text: 'Kamu sudah mengajukan dan pengajuan telah diterima.'
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
                                 || !in_array($statusPindahPkl->status, ['menunggu', 'ditolak']));
    @endphp

    @if ($bisaPengajuanBaru)
        <a href="{{ route('iduka.usulan') }}" class="dropdown-item">Pengajuan Baru</a>
    @else
        <a href="#" class="dropdown-item" onclick="Swal.fire({
            icon: 'info',
            title: 'Tidak Bisa Pengajuan Baru',
            text: 'Kamu hanya bisa membuat pengajuan baru jika pengajuan pindah tempat PKL diterima.',
            showConfirmButton: true,
            customClass: { popup: 'animate__animated animate__fadeIn' }
        })">Pengajuan Baru</a>
    @endif
</li>
                                </ul>
                            </div>

                            {{-- Pindah Tempat PKL --}}
                            @if ($sudahDiterima)
                                @php
                                    $pengajuanAktif = isset($statusPindahPkl) && in_array($statusPindahPkl->status, ['menunggu', 'diterima']);
                                @endphp
                                
                                @if(!$pengajuanAktif)
                                    <form action="{{ route('pindah-pkl.ajukan') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-warning ms-2"
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
                                                        <td>{{ $pindah->idukaBaru->nama ?? 'Tidak Diketahui' }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($pindah->created_at)->format('d/m/Y') }}</td>
                                                        <td>
                                                            @if($pindah->status == 'menunggu')
                                                                <span class="badge bg-warning">Menunggu</span>
                                                            @elseif($pindah->status == 'diterima')
                                                                <span class="badge bg-success">Diterima</span>
                                                            @elseif($pindah->status == 'ditolak')
                                                                <span class="badge bg-danger">Ditolak</span>
                                                            @else
                                                                <span class="badge bg-secondary">{{ $pindah->status }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-info btn-sm" 
                                                                    onclick="showDetailPindah({{ $pindah }})">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                            @if($pindah->status == 'diterima')
                                                                <a href="{{ route('pindah-pkl.download-surat', $pindah->id) }}" 
                                                                   class="btn btn-success btn-sm">
                                                                    <i class="bi bi-download"></i>
                                                                </a>
                                                            @endif
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
    Swal.fire({
        title: 'Detail Pengajuan Pindah PKL',
        html: `
            <div class="text-start">
                <p><strong>Tempat PKL Lama:</strong> ${pindah.iduka_lama ? pindah.iduka_lama.nama : 'Tidak Diketahui'}</p>
                <p><strong>Tempat PKL Baru:</strong> ${pindah.iduka_baru ? pindah.iduka_baru.nama : 'Tidak Diketahui'}</p>
                <p><strong>Tanggal Pengajuan:</strong> ${new Date(pindah.created_at).toLocaleDateString('id-ID')}</p>
                <p><strong>Status:</strong> <span class="text-capitalize">${pindah.status}</span></p>
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