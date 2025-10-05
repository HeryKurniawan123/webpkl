<div class="journal-view">
    <div class="row mb-4">
        <div class="col-md-6">
            <h6 class="text-muted">Tanggal</h6>
            <p class="fw-semibold">{{ \Carbon\Carbon::parse($jurnal->tgl)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
        </div>
        <div class="col-md-6">
            <h6 class="text-muted">Waktu Kegiatan</h6>
            <p class="fw-semibold">{{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}</p>
        </div>
    </div>

    <div class="mb-4">
        <h6 class="text-muted">Uraian Kegiatan</h6>
        <div class="p-3 bg-light rounded">
            <p class="mb-0" style="line-height: 1.6;">{!! nl2br(e($jurnal->uraian)) !!}</p>
        </div>
    </div>

    <!-- Tambahkan 2 field baru -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h6 class="text-muted">Termasuk Pengetahuan Baru</h6>
            @if($jurnal->is_pengetahuan_baru)
                <span class="badge bg-success">Ya</span>
            @else
                <span class="badge bg-secondary">Tidak</span>
            @endif
        </div>
        <div class="col-md-6">
            <h6 class="text-muted">Kegiatan dalam Mapel Sekolah</h6>
            @if($jurnal->is_dalam_mapel)
                <span class="badge bg-success">Ya</span>
            @else
                <span class="badge bg-secondary">Tidak</span>
            @endif
        </div>
    </div>

    @if($jurnal->foto)
        <div class="mb-4">
            <h6 class="text-muted">Foto Kegiatan</h6>
            <div class="text-center">
                <img src="{{ $jurnal->foto }}"
                     alt="Foto Kegiatan"
                     class="img-fluid rounded shadow-sm"
                     style="max-height: 300px; object-fit: cover;"
                     onclick="showImageModal(this.src)">
            </div>
        </div>
    @endif

    <!-- PERUBAHAN: Tampilkan status yang disederhanakan -->
    <div class="row mt-3">
        <div class="col-12">
            <h6 class="text-muted">Status Jurnal</h6>
            @if($jurnal->status == 'rejected')
                <span class="badge bg-danger">❌ Ditolak</span>
                @if($jurnal->rejected_reason)
                    <div class="mt-2 small text-danger">
                        <i class="bi bi-info-circle"></i> Alasan: {{ $jurnal->rejected_reason }}
                    </div>
                @endif
            @elseif($jurnal->status == 'approved')
                <span class="badge bg-success">✅ Disetujui</span>
                @if($jurnal->approved_by)
                    <div class="mt-2 small text-success">
                        <i class="bi bi-check-circle"></i> Disetujui oleh: {{ $jurnal->approved_by }}
                    </div>
                @endif
            @else
                <span class="badge bg-warning">⏳ Menunggu Persetujuan</span>
            @endif
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan gambar besar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Foto Kegiatan" class="img-fluid">
            </div>
        </div>
    </div>
</div>
