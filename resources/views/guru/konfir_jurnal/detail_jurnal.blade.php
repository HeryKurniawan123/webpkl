<div class="jurnal-detail">
    <div class="row">
        <div class="col-md-8">
            <div class="mb-3">
                <h6 class="text-muted">Nama Siswa/Mahasiswa</h6>
                <p class="fw-semibold">{{ $journal->user->name ?? 'Tidak diketahui' }}</p>
            </div>
            
            <div class="mb-3">
                <h6 class="text-muted">Tanggal Kegiatan</h6>
                <p>{{ \Carbon\Carbon::parse($journal->tgl)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
            </div>
            
            <div class="mb-3">
                <h6 class="text-muted">Waktu Kegiatan</h6>
                <p>{{ $journal->jam_mulai }} - {{ $journal->jam_selesai }}</p>
            </div>
            
            <div class="mb-3">
                <h6 class="text-muted">Uraian Kegiatan</h6>
                <p class="bg-light p-3 rounded">{{ $journal->uraian }}</p>
            </div>
            
            @if($journal->rejected_reason)
            <div class="mb-3">
                <h6 class="text-muted">Alasan Ditolak</h6>
                <p class="bg-light p-3 rounded text-danger">{{ $journal->rejected_reason }}</p>
            </div>
            @endif
        </div>
        
        <div class="col-md-4">
            <div class="mb-3">
                <h6 class="text-muted">Status Validasi</h6>
                <div class="d-flex flex-column gap-2">
                    @if($journal->validasi_pembimbing === 'sudah')
                        <span class="badge bg-success w-100">✅ Disetujui Pembimbing</span>
                    @elseif($journal->validasi_pembimbing === 'ditolak')
                        <span class="badge bg-danger w-100">❌ Ditolak Pembimbing</span>
                    @else
                        <span class="badge bg-warning w-100">⏳ Menunggu Pembimbing</span>
                    @endif
                    
                    @if($journal->validasi_iduka === 'sudah')
                        <span class="badge bg-success w-100">✅ Disetujui IDUKA</span>
                    @elseif($journal->validasi_iduka === 'ditolak')
                        <span class="badge bg-danger w-100">❌ Ditolak IDUKA</span>
                    @else
                        <span class="badge bg-warning w-100">⏳ Menunggu IDUKA</span>
                    @endif
                </div>
            </div>
            
            @if($journal->foto)
            <div class="mb-3">
                <h6 class="text-muted">Dokumentasi Kegiatan</h6>
                <img src="{{ asset('storage/' . $journal->foto) }}" alt="Dokumentasi kegiatan" 
                     class="img-fluid rounded" style="max-height: 200px;">
            </div>
            @endif
            
            <div class="mb-3">
                <h6 class="text-muted">Ditambahkan pada</h6>
                <p>{{ \Carbon\Carbon::parse($journal->created_at)->locale('id')->isoFormat('D MMMM YYYY HH:mm') }}</p>
            </div>
        </div>
    </div>
</div>