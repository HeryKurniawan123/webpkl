@extends('layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="mb-4">
        <h3 class="fw-bold">Persetujuan Jurnal - IDUKA 📖</h3>
        <p class="text-muted">Daftar jurnal yang membutuhkan persetujuan</p>
        
        {{-- Tab Navigation --}}
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('approval.iduka.index') }}">
                    <i class="bx bx-time me-1"></i> Menunggu Persetujuan
                    <span class="badge bg-primary rounded-pill ms-1">{{ $jurnals->total() }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('approval.iduka.riwayat') }}">
                    <i class="bx bx-history me-1"></i> Riwayat
                </a>
            </li>
        </ul>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm p-4">
        @if ($jurnals->count() > 0)
            <div class="row g-4">
                @foreach ($jurnals as $jurnal)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border rounded shadow-sm">
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($jurnal->tgl)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                    </small>
                                </div>
                                <h6 class="fw-semibold">
                                    Kegiatan Harian - {{ $jurnal->user ? $jurnal->user->name : 'User tidak ditemukan' }}
                                </h6>
                                <p class="text-truncate-3 text-muted mb-3">
                                    {{ Str::limit($jurnal->uraian, 120) }}
                                </p>
                                <div class="d-flex align-items-center gap-3 mb-3 small text-muted">
                                    <span>🕐 {{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}</span>
                                    @if ($jurnal->foto)
                                        <span>📷 Dengan foto</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    @if ($jurnal->validasi_pembimbing === 'sudah')
                                        <span class="badge bg-info text-white">✅ Disetujui Pembimbing</span>
                                    @else
                                        <span class="badge bg-warning text-dark">⏳ Menunggu Pembimbing</span>
                                    @endif
                                </div>
                                <div class="mt-auto d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary view-detail" 
                                            data-id="{{ $jurnal->id }}">
                                        Lihat Detail
                                    </button>
                                    
                                    <form action="{{ route('approval.iduka.approve', $jurnal->id) }}" method="POST" class="d-inline approve-form">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" 
                                                onclick="return confirmApproval('{{ $jurnal->user ? $jurnal->user->name : 'User' }}')">
                                            Setujui
                                        </button>
                                    </form>
                                    
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#rejectModal{{ $jurnal->id }}">
                                        Tolak
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Tolak -->
                    <div class="modal fade" id="rejectModal{{ $jurnal->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header">
                                    <h5 class="modal-title">Alasan Penolakan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('approval.reject', $jurnal->id) }}" method="POST" class="reject-form">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="rejected_reason" rows="3" 
                                                    placeholder="Masukkan alasan penolakan..." required></textarea>
                                            <div class="invalid-feedback">
                                                Alasan penolakan wajib diisi.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Tolak Jurnal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $jurnals->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div style="font-size: 50px;">✅</div>
                <h5 class="fw-bold mt-3">Tidak ada jurnal yang perlu disetujui</h5>
                <p class="text-muted">Semua jurnal telah diproses.</p>
                <a href="{{ route('approval.iduka.riwayat') }}" class="btn btn-primary mt-2">
                    Lihat Riwayat Persetujuan
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Modal Detail Jurnal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Jurnal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Konten akan diisi oleh JavaScript -->
            </div>
        </div>
    </div>
</div>

<script>
function confirmApproval(userName) {
    return confirm(`Apakah Anda yakin ingin menyetujui jurnal dari ${userName}?`);
}

// Handle modal detail
document.addEventListener('DOMContentLoaded', function() {
    const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
    
    // Handle click on view detail buttons
    document.querySelectorAll('.view-detail').forEach(button => {
        button.addEventListener('click', function() {
            const jurnalId = this.getAttribute('data-id');
            
            // Show loading
            document.getElementById('modalBody').innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat detail jurnal...</p>
                </div>
            `;
            
            detailModal.show();
            
            // Fetch detail via AJAX
            fetch(`/approval/${jurnalId}/detail`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('modalBody').innerHTML = data.data;
                    } else {
                        document.getElementById('modalBody').innerHTML = `
                            <div class="alert alert-danger">
                                Gagal memuat detail jurnal.
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    document.getElementById('modalBody').innerHTML = `
                        <div class="alert alert-danger">
                            Terjadi kesalahan: ${error}
                        </div>
                    `;
                });
        });
    });

    // Handle form submissions
    const approveForms = document.querySelectorAll('.approve-form');
    approveForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Memproses...';
        });
    });

    const rejectForms = document.querySelectorAll('.reject-form');
    rejectForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const textarea = this.querySelector('textarea[name="rejected_reason"]');
            if (!textarea.value.trim()) {
                e.preventDefault();
                textarea.classList.add('is-invalid');
                return false;
            }
            
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Memproses...';
        });
    });

    // Remove invalid class on textarea input
    const textareas = document.querySelectorAll('textarea[name="rejected_reason"]');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
    });
});

// Auto hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<style>
.text-truncate-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection