<div class="jurnal-detail">
    <div class="row">
        <div class="col-md-8">
            <!-- Student Information -->
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Nama Siswa</h6>
                            <p class="fw-semibold mb-0">{{ $journal->user->name ?? 'Tidak diketahui' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Details -->
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h6 class="text-muted mb-1">
                                <i class="bi bi-calendar3 me-1"></i> Tanggal Kegiatan
                            </h6>
                            <p class="mb-0">
                                {{ \Carbon\Carbon::parse($journal->tgl)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                            </p>
                        </div>
                        <div class="col-6">
                            <h6 class="text-muted mb-1">
                                <i class="bi bi-clock me-1"></i> Waktu Kegiatan
                            </h6>
                            <p class="mb-0">
                                <span class="badge bg-primary">{{ $journal->jam_mulai }} -
                                    {{ $journal->jam_selesai }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted mb-1">
                            <i class="bi bi-file-text me-1"></i> Uraian Kegiatan
                        </h6>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0">{{ $journal->uraian }}</p>
                        </div>
                    </div>

                    @if ($journal->rejected_reason)
                        <div>
                            <h6 class="text-muted mb-1">
                                <i class="bi bi-exclamation-triangle me-1"></i> Alasan Ditolak
                            </h6>
                            <div class="bg-danger bg-opacity-10 p-3 rounded border border-danger border-opacity-25">
                                <p class="mb-0 text-danger">{{ $journal->rejected_reason }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Validation Status -->
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-3">
                        <i class="bi bi-shield-check me-1"></i> Status Validasi
                    </h6>

                    <div class="d-grid gap-2">
                        @if ($journal->validasi_pembimbing === 'sudah')
                            <div class="alert alert-success d-flex align-items-center mb-0">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <span>Disetujui Pembimbing</span>
                            </div>
                        @elseif($journal->validasi_pembimbing === 'ditolak')
                            <div class="alert alert-danger d-flex align-items-center mb-0">
                                <i class="bi bi-x-circle-fill me-2"></i>
                                <span>Ditolak Pembimbing</span>
                            </div>
                        @else
                            <div class="alert alert-warning d-flex align-items-center mb-0">
                                <i class="bi bi-clock-fill me-2"></i>
                                <span>Menunggu Pembimbing</span>
                            </div>
                        @endif

                        @if ($journal->validasi_iduka === 'sudah')
                            <div class="alert alert-success d-flex align-items-center mb-0">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <span>Disetujui IDUKA</span>
                            </div>
                        @elseif($journal->validasi_iduka === 'ditolak')
                            <div class="alert alert-danger d-flex align-items-center mb-0">
                                <i class="bi bi-x-circle-fill me-2"></i>
                                <span>Ditolak IDUKA</span>
                            </div>
                        @else
                            <div class="alert alert-warning d-flex align-items-center mb-0">
                                <i class="bi bi-clock-fill me-2"></i>
                                <span>Menunggu IDUKA</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Documentation -->
            @if ($journal->foto)
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted mb-3">
                            <i class="bi bi-camera me-1"></i> Dokumentasi Kegiatan
                        </h6>
                        <div class="text-center">
                            <img src="{{ asset($journal->foto) }}" alt="Dokumentasi kegiatan"
                                class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                        </div>
                    </div>
                </div>
            @endif

            <!-- Additional Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-3">
                        <i class="bi bi-info-circle me-1"></i> Informasi Tambahan
                    </h6>

                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-calendar-plus text-muted me-2"></i>
                        <small class="text-muted">Ditambahkan:</small>
                    </div>
                    <p class="ms-4 mb-3">
                        {{ \Carbon\Carbon::parse($journal->created_at)->locale('id')->isoFormat('D MMMM YYYY HH:mm') }}
                    </p>

                    @if ($journal->updated_at != $journal->created_at)
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-arrow-clockwise text-muted me-2"></i>
                            <small class="text-muted">Diperbarui:</small>
                        </div>
                        <p class="ms-4 mb-0">
                            {{ \Carbon\Carbon::parse($journal->updated_at)->locale('id')->isoFormat('D MMMM YYYY HH:mm') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
