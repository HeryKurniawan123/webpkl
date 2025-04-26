@extends('layout.main')

@section('content')
<style>
    .btn-back {
        background-color: #7e7dfb;
        color: white;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        border: none;
        padding: 7px 14px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out, background-color 0.2s ease-in-out;
    }

    .btn-back:hover,
    .btn-reset:hover {
        background-color: #7e7dfb;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.25);
    }

    .btn-back:active,
    .btn-reset:hover {
        color: white;
        background-color: #6b6bfa !important;
        transform: translateY(3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .btn-reset {
        background-color: #7e7dfb;
        color: white;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        border: none;
        padding: 6px 12px;
        border-radius: 5px;
        font-size: 14px;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out, background-color 0.2s ease-in-out;
    }
</style>
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="col-md-12 mt-3 d-flex justify-content-between align-items-center">
                        <h4 class="mb-3">History Pengajuan Diterima</h4>
                        <button class="btn btn-reset shadow-sm">Reset Data</button>
                    </div>
                    <div class="card shadow-sm" style="padding: 20px;">
                        @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">                        
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Nama IDUKA</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th>Surat Izin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data History Diterima -->
                                @foreach($usulanDiterima as $index => $usulan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $usulan->user->name }}</td>
                                    <td>{{ $usulan->user->dataPribadi->kelas->kelas ?? '-' }}{{ $usulan->user->dataPribadi->kelas->name_kelas ?? '-' }}</td>
                                    <td>{{ $usulan->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($usulan->created_at)->format('d-m-Y') }}</td>
                                    <td><span class="badge bg-success">Diterima</span></td>
                                    <td>
                                        @if($usulan->surat_izin == 'belum')
                                        <form class="form-surat-izin" data-id="{{ $usulan->id }}" data-tipe="usulan">
                                            @csrf
                                            <button type="button" class="btn btn-warning btn-sm btn-surat-izin">
                                                Belum
                                            </button>
                                        </form>
                                        @else
                                        <span class="badge bg-success">Sudah</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                                @endforeach
                                @if($usulanDiterima->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada pengajuan diterima.</td>
                                </tr>
                                @endif

                                @foreach ($usulanDiterimaPkl as $usul)
                                <tr>
                                    <td>{{ $index + 2 }}</td>
                                    <td>{{ $usul->user->name }}</td>
                                    <td>{{ $usul->user->dataPribadi->kelas->kelas ?? '-' }}{{ $usul->user->dataPribadi->kelas->name_kelas ?? '-' }}</td>
                                    <td>{{ $usul->iduka->nama ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($usul->created_at)->format('d-m-Y') }}</td>
                                    <td><span class="badge bg-success">Diterima</span></td>
                                    <td>
                                        @if($usul->surat_izin == 'belum')
                                        <form class="form-surat-izin" data-id="{{ $usul->id }}" data-tipe="pkl">
                                            @csrf
                                            <button type="button" class="btn btn-warning btn-sm btn-surat-izin">
                                                Belum
                                            </button>
                                        </form>
                                        @else
                                        <span class="badge bg-success">Sudah</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                </tr>
                                @endforeach
                                <!-- Add more rows here -->
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content mt-3 mb-2">
                    <a href="{{ route('review.usulan')}}" class="btn btn-back shadow-sm">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn-surat-izin');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.form-surat-izin');
                const id = form.getAttribute('data-id');
                const tipe = form.getAttribute('data-tipe');
                const csrfToken = form.querySelector('input[name="_token"]').value;

                fetch(`/kaprog/update-surat-izin/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            tipe: tipe
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('HTTP status ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response:', data);
                        if (data.success) {
                            form.outerHTML = '<span class="badge bg-success">Sudah</span>';
                            Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Surat izin berhasil diperbarui, dan dikirim ke Persuratan',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: data.message || 'Terjadi kesalahan!',
                            });

                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal memperbarui surat izin. Silakan coba lagi.',
                        });

                    });


            });
        });
    });
</script>