@extends('layout.main')
@section('content')

<div class="container-fluid">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="card-header" style="background-color: #7e7dfb">
                    <h5 style="color: white;">Review Pengajuan PKL</h5>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5>Data Siswa</h5>
                        <table class="table table-striped">
                            <tr>
                                <td>Nama Siswa</td>
                                <td>:</td>
                                <td>{{ $usulan->user->name }}</td>
                            </tr>
                            <tr>
                                <td>NIS</td>
                                <td>:</td>
                                <td>{{ $usulan->user->dataPribadi->nip }}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>:</td>
                                <td>{{ $usulan->user->dataPribadi->kelas->name_kelas ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Konsentrasi Keahlian</td>
                                <td>:</td>
                                <td>{{ $usulan->user->dataPribadi->konkes->name_konke ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td>{{ $usulan->user->dataPribadi->jk }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td>{{ $usulan->user->dataPribadi->alamat_siswa }}</td>
                            </tr>
                            <tr>
                                <td>Tempat Lahir</td>
                                <td>:</td>
                                <td>{{ $usulan->user->dataPribadi->tempat_lhr }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir</td>
                                <td>:</td>
                                <td>{{ date('d F Y', strtotime($usulan->user->dataPribadi->tgl_lahir)) }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $usulan->user->email }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Telepon</td>
                                <td>:</td>
                                <td>{{ $usulan->user->dataPribadi->no_hp }}</td>
                            </tr>
                        </table>

                        <h5 class="mt-4">Data Institusi / Perusahaan yang Diajukan</h5>
                        <table class="table table-striped">
                            <tr>
                                <td>Nama Institusi</td>
                                <td>:</td>
                                <td>{{ $usulan->nama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Nama Pimpinan</td>
                                <td>:</td>
                                <td>{{ $usulan->nama_pimpinan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>NIP/NIP Pimpinan</td>
                                <td>:</td>
                                <td>{{ $usulan->nip_pimpinan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>:</td>
                                <td>{{ $usulan->jabatan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Alamat Lengkap Institusi</td>
                                <td>:</td>
                                <td>{{ $usulan->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Kode Pos</td>
                                <td>:</td>
                                <td>{{ $usulan->kode_pos ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>No Telepon Kantor/Perusahaan</td>
                                <td>:</td>
                                <td>{{ $usulan->telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $usulan->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Bidang Industri</td>
                                <td>:</td>
                                <td>{{ $usulan->bidang_industri ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Kerja Sama</td>
                                <td>:</td>
                                <td>{{ $usulan->kerjasama ?? '-' }}</td>
                            </tr>
                        </table>

                        <div class="d-flex justify-content-between mt-3">
                            <div>
                                <a href="{{ route('review.usulan') }}" class="btn btn-back shadow-sm">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                            </div>

                            <div class="d-flex gap-2">
                                <button class="btn btn-success btn-update-status" data-id="{{ $usulan->id }}" data-status="diterima">
                                    Terima
                                </button>
                                <button class="btn btn-danger btn-update-status" data-id="{{ $usulan->id }}" data-status="ditolak">
                                    Tolak
                                </button>                                                                               
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script SweetAlert dan Axios -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const buttons = document.querySelectorAll('.btn-update-status');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const status = this.dataset.status;
                const statusText = status === 'diterima' ? 'Terima' : 'Tolak';
                const iconType = status === 'diterima' ? 'success' : 'warning';

                Swal.fire({
                    title: `${statusText} Pengajuan?`,
                    text: `Apakah kamu yakin ingin ${statusText.toLowerCase()} pengajuan ini?`,
                    icon: iconType,
                    showCancelButton: true,
                    confirmButtonText: 'Ya, lanjutkan!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.showLoading();

                        axios.put(`/usulan-diterimaUsulanIduka/${id}`, {
    status: status
})
.then(response => {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: `Pengajuan berhasil ${statusText.toLowerCase()}.`,
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = "{{ route('review.usulan') }}";  // Arahkan ke halaman review usulan
    });
})
.catch(error => {
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: error.response?.data?.message || 'Terjadi kesalahan saat memperbarui status.',
    });
});
                    }
                });
            });
        });
    });
</script>
@endpush

@endsection
