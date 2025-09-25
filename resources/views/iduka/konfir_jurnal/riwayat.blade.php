@extends('layout.main')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Riwayat Konfirmasi Jurnal</h2>
                    <p class="text-muted mb-0">
                        @if(auth()->user()->role === 'guru')
                            Daftar jurnal yang telah dikonfirmasi sebagai Pembimbing
                        @elseif(auth()->user()->role === 'iduka')
                            Daftar jurnal yang telah dikonfirmasi sebagai IDUKA
                        @else
                            Daftar jurnal yang telah dikonfirmasi
                        @endif
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('approval.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($jurnals->isEmpty())
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-journal-text text-muted" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="text-muted mb-2">Belum Ada Riwayat</h5>
                        <p class="text-muted mb-0">
                            @if(auth()->user()->role === 'guru')
                                Belum ada jurnal yang dikonfirmasi sebagai pembimbing.
                            @elseif(auth()->user()->role === 'iduka')
                                Belum ada jurnal yang dikonfirmasi sebagai IDUKA.
                            @else
                                Belum ada jurnal yang telah dikonfirmasi.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-check-circle text-success"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <div class="fs-5 fw-bold text-success">
                                    @if(auth()->user()->role === 'guru')
                                        {{ $jurnals->where('validasi_pembimbing', 'sudah')->count() }}
                                    @elseif(auth()->user()->role === 'iduka')
                                        {{ $jurnals->where('validasi_iduka', 'sudah')->count() }}
                                    @else
                                        {{ $jurnals->where('status', '!=', 'rejected')->count() }}
                                    @endif
                                </div>
                                <div class="text-muted small">Disetujui</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-x-circle text-danger"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <div class="fs-5 fw-bold text-danger">
                                    @if(auth()->user()->role === 'guru')
                                        {{ $jurnals->where('validasi_pembimbing', 'ditolak')->count() }}
                                    @elseif(auth()->user()->role === 'iduka')
                                        {{ $jurnals->where('validasi_iduka', 'ditolak')->count() }}
                                    @else
                                        {{ $jurnals->where('status', 'rejected')->count() }}
                                    @endif
                                </div>
                                <div class="text-muted small">Ditolak</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-clock text-info"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <div class="fs-5 fw-bold text-info">
                                    @if(auth()->user()->role === 'guru')
                                        {{ $jurnals->where('validasi_pembimbing', 'belum')->count() }}
                                    @elseif(auth()->user()->role === 'iduka')
                                        {{ $jurnals->where('validasi_iduka', 'belum')->count() }}
                                    @else
                                        {{ $jurnals->where('status', 'pending')->count() }}
                                    @endif
                                </div>
                                <div class="text-muted small">
                                    @if(auth()->user()->role === 'guru')
                                        Belum Dikonfirmasi
                                    @elseif(auth()->user()->role === 'iduka')
                                        Belum Dikonfirmasi
                                    @else
                                        Menunggu
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-journal-text text-primary"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <div class="fs-5 fw-bold text-primary">
                                    {{ $jurnals->total() }}
                                </div>
                                <div class="text-muted small">Total Riwayat</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                @if(auth()->user()->role === 'guru')
                                    Riwayat Konfirmasi sebagai Pembimbing
                                @elseif(auth()->user()->role === 'iduka')
                                    Riwayat Konfirmasi sebagai IDUKA
                                @else
                                    Daftar Riwayat Jurnal
                                @endif
                            </h6>
                            <small class="text-muted">Menampilkan {{ $jurnals->count() }} dari {{ $jurnals->total() }} jurnal</small>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Siswa</th>
                                        <th>Waktu Kegiatan</th>
                                        <th>
                                            @if(auth()->user()->role === 'guru')
                                                Status Konfirmasi Pembimbing
                                            @elseif(auth()->user()->role === 'iduka')
                                                Status Konfirmasi IDUKA
                                            @else
                                                Status Validasi
                                            @endif
                                        </th>
                                        <th>Terakhir Diperbarui</th>
                                        <th class="pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jurnals as $journal)
                                    <tr>
                                        <td class="ps-4">{{ ($jurnals->currentPage() - 1) * $jurnals->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-semibold">{{ \Carbon\Carbon::parse($journal->tgl)->locale('id')->isoFormat('D MMM YYYY') }}</span>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($journal->tgl)->locale('id')->isoFormat('dddd') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="bi bi-person-fill text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $journal->user->name ?? 'Tidak diketahui' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $journal->jam_mulai }} - {{ $journal->jam_selesai }}</span>
                                        </td>
                                        <td>
                                            @if(auth()->user()->role === 'guru')
                                                <!-- Status untuk Guru/Pembimbing -->
                                                @if($journal->validasi_pembimbing === 'sudah')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Disetujui
                                                    </span>
                                                @elseif($journal->validasi_pembimbing === 'ditolak')
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle me-1"></i>Ditolak
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-clock me-1"></i>Belum Dikonfirmasi
                                                    </span>
                                                @endif
                                            @elseif(auth()->user()->role === 'iduka')
                                                <!-- Status untuk IDUKA -->
                                                @if($journal->validasi_iduka === 'sudah')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Disetujui
                                                    </span>
                                                @elseif($journal->validasi_iduka === 'ditolak')
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle me-1"></i>Ditolak
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-clock me-1"></i>Belum Dikonfirmasi
                                                    </span>
                                                @endif
                                            @else
                                                <!-- Status umum jika ada role lain -->
                                                @if($journal->status === 'rejected')
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-x-circle me-1"></i>Ditolak
                                                    </span>
                                                @elseif($journal->validasi_pembimbing === 'sudah' && $journal->validasi_iduka === 'sudah')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Disetujui
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-clock me-1"></i>Menunggu
                                                    </span>
                                                @endif
                                            @endif
                                            
                                            <!-- Indikator status keseluruhan untuk konteks -->
                                            @if(auth()->user()->role === 'guru' && $journal->validasi_iduka === 'sudah')
                                                <br><small class="text-success">✓ IDUKA sudah menyetujui</small>
                                            @elseif(auth()->user()->role === 'guru' && $journal->validasi_iduka === 'ditolak')
                                                <br><small class="text-danger">✗ IDUKA menolak</small>
                                            @elseif(auth()->user()->role === 'guru' && $journal->validasi_iduka === 'belum')
                                                <br><small class="text-muted">⏳ Menunggu IDUKA</small>
                                            @endif
                                            
                                            @if(auth()->user()->role === 'iduka' && $journal->validasi_pembimbing === 'sudah')
                                                <br><small class="text-success">✓ Pembimbing sudah menyetujui</small>
                                            @elseif(auth()->user()->role === 'iduka' && $journal->validasi_pembimbing === 'ditolak')
                                                <br><small class="text-danger">✗ Pembimbing menolak</small>
                                            @elseif(auth()->user()->role === 'iduka' && $journal->validasi_pembimbing === 'belum')
                                                <br><small class="text-muted">⏳ Menunggu Pembimbing</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="small">{{ \Carbon\Carbon::parse($journal->updated_at)->locale('id')->isoFormat('D MMM YYYY') }}</span>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($journal->updated_at)->diffForHumans() }}</small>
                                            </div>
                                        </td>
                                        <td class="pe-4">
                                            <button type="button" class="btn btn-sm btn-outline-info" 
                                                    onclick="showJournalDetail('{{ $journal->id }}')"
                                                    data-bs-toggle="modal" data-bs-target="#journalDetailModal"
                                                    title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($jurnals->hasPages())
                    <div class="card-footer bg-white border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Menampilkan {{ $jurnals->firstItem() }} - {{ $jurnals->lastItem() }} dari {{ $jurnals->total() }} hasil
                            </div>
                            <div>
                                {{ $jurnals->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modal Detail Jurnal -->
<div class="modal fade" id="journalDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light border-bottom">
                <h5 class="modal-title">
                    <i class="bi bi-journal-text me-2"></i>Detail Jurnal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="journalDetailContent">
                    <div class="d-flex justify-content-center align-items-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.table tbody tr {
    transition: background-color 0.2s ease;
}

.table tbody tr:hover {
    background-color: rgba(0,123,255,0.05);
}

.badge {
    font-weight: 500;
}

.modal-content {
    border-radius: 12px;
}

.modal-header {
    border-radius: 12px 12px 0 0;
}

.spinner-border {
    width: 2rem;
    height: 2rem;
}

@media (max-width: 768px) {
    .container-fluid {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
function showJournalDetail(id) {
    // Reset modal content
    document.getElementById('journalDetailContent').innerHTML = `
        <div class="d-flex justify-content-center align-items-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;

    fetch(`/approval/detail/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('journalDetailContent').innerHTML = data.data;
            } else {
                document.getElementById('journalDetailContent').innerHTML = `
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Gagal memuat detail jurnal: ${data.message}
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('journalDetailContent').innerHTML = `
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Terjadi kesalahan saat memuat detail jurnal. Silakan coba lagi.
                </div>
            `;
        });
}

// Auto refresh setiap 30 detik jika ada data
@if(!$jurnals->isEmpty())
setInterval(function() {
    // Optional: Auto refresh jika diperlukan
    // location.reload();
}, 30000);
@endif
</script>
@endpush
@endsection