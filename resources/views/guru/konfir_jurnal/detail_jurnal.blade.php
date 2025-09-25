<div class="jurnal-detail">
    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Student Information -->
            <div class="card border-0 bg-light mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="bi bi-person-fill text-primary fs-5"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Nama Siswa/Mahasiswa</h6>
                            <p class="fw-semibold mb-0 fs-5">{{ $journal->user->name ?? 'Tidak diketahui' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Activity Details -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="bi bi-calendar-event me-2"></i>Detail Kegiatan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">
                                    <i class="bi bi-calendar3 me-1"></i>Tanggal Kegiatan
                                </h6>
                                <p class="mb-0">{{ \Carbon\Carbon::parse($journal->tgl)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6 class="text-muted mb-2">
                                    <i class="bi bi-clock me-1"></i>Waktu Kegiatan
                                </h6>
                                <p class="mb-0">
                                    <span class="badge bg-primary">{{ $journal->jam_mulai }} - {{ $journal->jam_selesai }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">
                            <i class="bi bi-file-text me-1"></i>Uraian Kegiatan
                        </h6>
                        <div class="bg-light p-3 rounded border">
                            <p class="mb-0">{{ $journal->uraian }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Rejection Reason (if any) -->
            @if($journal->rejected_reason)
            <div class="card border-danger mb-3">
                <div class="card-header bg-danger bg-opacity-10 border-danger">
                    <h6 class="mb-0 text-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>Alasan Ditolak
                    </h6>
                </div>
                <div class="card-body">
                    <div class="bg-danger bg-opacity-5 p-3 rounded border border-danger border-opacity-25">
                        <p class="mb-0 text-danger">{{ $journal->rejected_reason }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Validation Status -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="bi bi-shield-check me-2"></i>Status Validasi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        <!-- Pembimbing Status -->
                        <div class="d-flex align-items-center {{ auth()->user()->role === 'guru' ? 'border rounded p-2 bg-light' : '' }}">
                            <div class="me-3">
                                @if($journal->validasi_pembimbing === 'sudah')
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                        <i class="bi bi-check-circle text-success"></i>
                                    </div>
                                @elseif($journal->validasi_pembimbing === 'ditolak')
                                    <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                                        <i class="bi bi-x-circle text-danger"></i>
                                    </div>
                                @else
                                    <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                        <i class="bi bi-clock text-warning"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">
                                    Pembimbing
                                    @if(auth()->user()->role === 'guru')
                                        <span class="badge bg-primary ms-1">Anda</span>
                                    @endif
                                </div>
                                @if($journal->validasi_pembimbing === 'sudah')
                                    <small class="text-success">Disetujui</small>
                                    @if($journal->approved_pembimbing_at)
                                        <small class="text-muted d-block">{{ \Carbon\Carbon::parse($journal->approved_pembimbing_at)->locale('id')->diffForHumans() }}</small>
                                    @endif
                                @elseif($journal->validasi_pembimbing === 'ditolak')
                                    <small class="text-danger">Ditolak</small>
                                @else
                                    <small class="text-warning">Menunggu persetujuan</small>
                                @endif
                            </div>
                        </div>
                        
                        <!-- IDUKA Status -->
                        <div class="d-flex align-items-center {{ auth()->user()->role === 'iduka' ? 'border rounded p-2 bg-light' : '' }}">
                            <div class="me-3">
                                @if($journal->validasi_iduka === 'sudah')
                                    <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                        <i class="bi bi-check-circle text-success"></i>
                                    </div>
                                @elseif($journal->validasi_iduka === 'ditolak')
                                    <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                                        <i class="bi bi-x-circle text-danger"></i>
                                    </div>
                                @else
                                    <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                        <i class="bi bi-clock text-warning"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">
                                    IDUKA
                                    @if(auth()->user()->role === 'iduka')
                                        <span class="badge bg-primary ms-1">Anda</span>
                                    @endif
                                </div>
                                @if($journal->validasi_iduka === 'sudah')
                                    <small class="text-success">Disetujui</small>
                                    @if($journal->approved_iduka_at)
                                        <small class="text-muted d-block">{{ \Carbon\Carbon::parse($journal->approved_iduka_at)->locale('id')->diffForHumans() }}</small>
                                    @endif
                                @elseif($journal->validasi_iduka === 'ditolak')
                                    <small class="text-danger">Ditolak</small>
                                @else
                                    <small class="text-warning">Menunggu persetujuan</small>
                                @endif
                            </div>
                        </div>

                        <!-- Overall Status -->
                        @if($journal->validasi_pembimbing === 'sudah' && $journal->validasi_iduka === 'sudah')
                            <div class="alert alert-success mb-0">
                                <i class="bi bi-check-circle me-2"></i>
                                <strong>Jurnal telah disetujui oleh kedua pihak</strong>
                            </div>
                        @elseif($journal->status === 'rejected')
                            <div class="alert alert-danger mb-0">
                                <i class="bi bi-x-circle me-2"></i>
                                <strong>Jurnal ditolak</strong>
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">
                                <i class="bi bi-clock me-2"></i>
                                <strong>Menunggu persetujuan dari 
                                @if($journal->validasi_pembimbing === 'belum' && $journal->validasi_iduka === 'belum')
                                    kedua pihak
                                @elseif($journal->validasi_pembimbing === 'belum')
                                    pembimbing
                                @else
                                    IDUKA
                                @endif
                                </strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Documentation -->
            @if($journal->foto)
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="bi bi-camera me-2"></i>Dokumentasi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $journal->foto) }}" 
                             alt="Dokumentasi kegiatan" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 250px; cursor: pointer;"
                             onclick="showImageModal(this.src)">
                        <small class="text-muted d-block mt-2">Klik untuk memperbesar</small>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Metadata -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>Informasi Tambahan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Ditambahkan:</small>
                            <small class="fw-semibold">{{ \Carbon\Carbon::parse($journal->created_at)->locale('id')->isoFormat('D MMM YYYY HH:mm') }}</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Terakhir diperbarui:</small>
                            <small class="fw-semibold">{{ \Carbon\Carbon::parse($journal->updated_at)->locale('id')->isoFormat('D MMM YYYY HH:mm') }}</small>
                        </div>
                        @if($journal->approved_pembimbing_at)
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Disetujui Pembimbing:</small>
                            <small class="fw-semibold text-success">{{ \Carbon\Carbon::parse($journal->approved_pembimbing_at)->locale('id')->isoFormat('D MMM YYYY HH:mm') }}</small>
                        </div>
                        @endif
                        @if($journal->approved_iduka_at)
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Disetujui IDUKA:</small>
                            <small class="fw-semibold text-success">{{ \Carbon\Carbon::parse($journal->approved_iduka_at)->locale('id')->isoFormat('D MMM YYYY HH:mm') }}</small>
                        </div>
                        @endif
                        @if($journal->rejected_at)
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Ditolak pada:</small>
                            <small class="fw-semibold text-danger">{{ \Carbon\Carbon::parse($journal->rejected_at)->locale('id')->isoFormat('D MMM YYYY HH:mm') }}</small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h6 class="modal-title">Dokumentasi Kegiatan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Dokumentasi" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<script>
function showImageModal(src) {
    document.getElementById('modalImage').src = src;
    const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    imageModal.show();
}
</script>