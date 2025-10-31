@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Pengajuan Pindah PKL Selesai</h1>
        <a href="{{ route('persuratan.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('persuratan.pindah_pkl.index') }}">Menunggu Konfirmasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Selesai</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Tempat PKL</th>
                            <th>Tanggal Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pindah as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        <span class="avatar-title rounded-circle bg-primary text-white">
                                            {{ strtoupper(substr($item->nama_siswa, 0, 1)) }}
                                        </span>
                                    </div>
                                    <span>{{ $item->nama_siswa }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $item->kelas_id }}</span>
                            </td>
                            <td>{{ $item->nama_iduka }}</td>
                            <td>{{ date('d M Y', strtotime($item->updated_at)) }}</td>
                            <td>
                                @switch($item->status)
                                    @case('siap_kirim')
                                        <span class="badge bg-success">Siap Dikirim ke IDUKA</span>
                                        @break
                                    @case('ditolak_persuratan')
                                        <span class="badge bg-danger">Ditolak</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $item->status }}</span>
                                @endswitch
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-check-circle fa-2x mb-2 d-block"></i>
                                    Belum ada pengajuan pindah PKL yang selesai
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    font-weight: 500;
}
</style>
@endpush
