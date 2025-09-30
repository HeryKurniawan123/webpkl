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

    @if($jurnal->foto)
        <div class="mb-4">
            <h6 class="text-muted">Foto Kegiatan</h6>
            <div class="text-center">
                <img src="{{ $jurnal->foto }}"
                     alt="Foto Kegiatan"
                     class="img-fluid rounded shadow-sm"
                     style="max-height: 300px; object-fit: cover;">
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <h6 class="text-muted">Status Validasi Pembimbing</h6>
            @if($jurnal->status == 'rejected')
                <span class="badge bg-danger">❌ Ditolak</span>
                @if($jurnal->rejected_reason)
                    <div class="mt-2 small text-danger">
                        <i class="bi bi-info-circle"></i> Alasan: {{ $jurnal->rejected_reason }}
                    </div>
                @endif
            @elseif($jurnal->validasi_pembimbing == 'sudah')
                <span class="badge bg-success">✅ Sudah Disetujui</span>
            @else
                <span class="badge bg-warning">⏳ Menunggu Persetujuan</span>
            @endif
        </div>

        <div class="col-md-6">
            <h6 class="text-muted">Status Validasi IDUKA</h6>
            @if($jurnal->status == 'rejected')
                <span class="badge bg-danger">❌ Ditolak</span>
                @if($jurnal->rejected_reason)
                    <div class="mt-2 small text-danger">
                        <i class="bi bi-info-circle"></i> Alasan: {{ $jurnal->rejected_reason }}
                    </div>
                @endif
            @elseif($jurnal->validasi_iduka == 'sudah')
                <span class="badge bg-success">✅ Sudah Disetujui</span>
            @else
                <span class="badge bg-warning">⏳ Menunggu Persetujuan</span>
            @endif
        </div>
    </div>
</div>
