@extends('layout.main')

@section('content')
    <style>
        .btn-back, .btn-reset {
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

        .btn-back:hover, .btn-reset:hover {
            background-color: #6b6bfa;
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.25);
        }

        .btn-reset {
            font-size: 14px;
            margin-bottom: 0.5rem;
        }
    </style>

    <div class="container-fluid">
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-3">History Pengajuan Diterima</h4>
                            <button class="btn btn-reset shadow-sm">Reset Data</button>
                        </div>
                        <div class="card shadow-sm p-3">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Nama IDUKA</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pengajuans as $key => $pengajuan)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $pengajuan->dataPribadi->user->name ?? 'Tidak Tersedia' }}</td>
                                            <td>{{ $pengajuan->dataPribadi->kelas->name_kelas ?? '-' }}</td>
                                            <td>{{ $pengajuan->iduka->nama ?? '-' }}</td>
                                            <td>{{ $pengajuan->created_at->format('d/m/Y') }}</td>
                                            <td><span class="badge bg-danger">Ditolak</span></td>

                                            <td>
                                                <form action="" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data tersedia</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('review.pengajuan') }}" class="btn btn-back shadow-sm">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
