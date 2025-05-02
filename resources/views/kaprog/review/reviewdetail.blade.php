@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="card mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Pengajuan PKL ke: {{ $iduka->nama }}</h5>
                        <a href="{{ route('kaprog.review.pengajuan') }}" class="btn btn-secondary btn-sm">
                            <span class="d-none d-sm-inline">Kembali</span>
                        </a>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    @if ($pengajuans->isEmpty())
                    <p class="text-center">Tidak ada pengajuan yang tersedia untuk Institusi ini.</p>
                    @else
                        @foreach ($pengajuans as $pengajuan)
                            <div class="card mb-3 shadow-sm" style="padding: 20px; border-radius: 10px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="mb-0" style="font-size: 18px">
                                            <strong>{{ $pengajuan->dataPribadi->name ?? 'Nama Tidak Tersedia' }}</strong>
                                        </div>
                                        <div>
                                            Kelas: {{ $pengajuan->dataPribadi->kelas->kelas ?? '-' }}
                                            {{ $pengajuan->dataPribadi->kelas->name_kelas ?? '-' }}
                                        </div>
                                        <div>
                                            Status: {{ ucfirst($pengajuan->status) }}
                                        </div>
                                    </div>
                                    <div class="d-inline-block position-relative">
                                        <!-- Desktop: Tombol langsung -->
                                        <div class="d-none d-md-flex gap-2">
                                            <a href="{{ route('persuratan.suratPengajuan.detailSuratPengajuan', $pengajuan->id) }}" class="btn btn-primary rounded-pill">
                                                Lihat Detail
                                            </a>

                                            @if ($pengajuan->status === 'diterima')
                                                <button class="btn btn-primary rounded-pill" disabled>Sudah Dikirim</button>
                                            @else
                                                <form action="{{ route('kaprog.pengajuan.prosesPengajuan', $pengajuan->id) }}" method="POST" id="form-{{ $pengajuan->id }}">
                                                    @csrf
                                                    <input type="hidden" name="iduka_id" value="{{ $iduka->id }}">
                                                    <button type="button" class="btn btn-primary rounded-pill" onclick="confirmKirim('{{ $pengajuan->id }}')">
                                                        Kirim
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        <!-- Mobile: Dropdown tiga titik -->
                                        <div class="dropdown d-md-none">
                                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                               <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a href="{{ route('persuratan.suratPengajuan.detailSuratPengajuan', $pengajuan->id) }}" class="dropdown-item text-success">
                                                        Lihat Detail
                                                    </a>
                                                </li>
                                                @if ($pengajuan->status === 'diterima')
                                                    <li>
                                                        <button class="dropdown-item text-muted" disabled>Sudah Dikirim</button>
                                                    </li>
                                                @else
                                                    <li>
                                                        <form action="{{ route('kaprog.pengajuan.prosesPengajuan', $pengajuan->id) }}" method="POST" id="form-mobile-{{ $pengajuan->id }}">
                                                            @csrf
                                                            <input type="hidden" name="iduka_id" value="{{ $iduka->id }}">
                                                            <button type="button" class="dropdown-item text-primary" onclick="confirmKirimMobile('{{ $pengajuan->id }}')">
                                                                Kirim
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-inline-block position-relative">
                                <!-- Desktop: Tombol langsung -->
                                <div class="d-none d-md-flex gap-2">
                                    <a href="{{ route('persuratan.suratPengajuan.detailSuratPengajuan', $pengajuan->id) }}" class="btn btn-success">
                                        Lihat Detail
                                    </a>

                                    @if ($pengajuan->status === 'diterima')
                                    <button class="btn btn-success" disabled>Sudah Dikirim</button>
                                    @else
                                    <form action="{{ route('kaprog.pengajuan.prosesPengajuan', $pengajuan->id) }}" method="POST" id="form-{{ $pengajuan->id }}">
                                        @csrf
                                        <input type="hidden" name="iduka_id" value="{{ $iduka->id }}">
                                        <button type="button" class="btn btn-primary" onclick="confirmKirim('{{ $pengajuan->id }}')">
                                            Kirim
                                        </button>
                                    </form>
                                    @endif
                                </div>

                                <!-- Mobile: Dropdown tiga titik -->
                                <div class="dropdown d-md-none">
                                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        ⋮
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="{{ route('persuratan.suratPengajuan.detailSuratPengajuan', $pengajuan->id) }}" class="dropdown-item text-success">
                                                Lihat Detail
                                            </a>
                                        </li>
                                        @if ($pengajuan->status === 'diterima')
                                        <li>
                                            <button class="dropdown-item text-muted" disabled>Sudah Dikirim</button>
                                        </li>
                                        @elseif ($pengajuan->status === 'menunggu pembatalan')
                                        <form action="{{ route('kaprog.pengajuan.setujuiPembatalan', $pengajuan->id) }}" method="POST" onsubmit="return confirm('Setujui pembatalan pengajuan ini?')">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-danger">Setujui Batal</button>
                                        </form>
                                        <li>
                                        @else
                                            <form action="{{ route('kaprog.pengajuan.prosesPengajuan', $pengajuan->id) }}" method="POST" id="form-mobile-{{ $pengajuan->id }}">
                                                @csrf
                                                <input type="hidden" name="iduka_id" value="{{ $iduka->id }}">
                                                <button type="button" class="dropdown-item text-primary" onclick="confirmKirimMobile('{{ $pengajuan->id }}')">
                                                    Kirim
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmKirim(id) {
        Swal.fire({
            title: 'Yakin?',
            text: "Ingin mengirim pengajuan ini ke IDUKA?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kirim!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-' + id).submit();
            }
        });
    }

    function confirmKirimMobile(id) {
        Swal.fire({
            title: 'Yakin?',
            text: "Ingin mengirim pengajuan ini ke IDUKA?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Kirim!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-mobile-' + id).submit();
            }
        });
    }

    // Jika ada flash message dari server, tampilkan
    @if(session('success'))
    Swal.fire({
        title: 'Berhasil!',
        text: '{{ session('
        success ') }}',
        icon: 'success',
        timer: 1500,
        showConfirmButton: false
    });
    @endif

    @if(session('error'))
    Swal.fire({
        title: 'Gagal!',
        text: '{{ session('
        error ') }}',
        icon: 'error',
        showConfirmButton: true
    });
    @endif

    @if(session('info'))
    Swal.fire({
        title: 'Info!',
        text: '{{ session('
        info ') }}',
        icon: 'info',
        showConfirmButton: true
    });
    @endif
</script>
@endpush