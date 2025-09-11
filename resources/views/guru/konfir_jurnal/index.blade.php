@extends('layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="mb-4">
        <h3 class="fw-bold">Persetujuan Jurnal - IDUKA 📖</h3>
        <p class="text-muted">Daftar jurnal yang membutuhkan persetujuan</p>
    </div>

    <div class="card shadow-sm p-4">
        <h5 class="mb-3">📌 Jurnal Menunggu Persetujuan</h5>

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
                                    @if ($jurnal->status === 'pending')
                                        <span class="badge bg-warning text-dark">⏳ Menunggu Persetujuan</span>
                                    @elseif ($jurnal->status === 'approved_pembimbing')
                                        <span class="badge bg-success">✅ Disetujui Pembimbing</span>
                                    @endif
                                </div>
                                <div class="mt-auto d-flex gap-2">
                                    <a href="{{ route('approval.show', $jurnal->id) }}" class="btn btn-sm btn-outline-primary">
                                        Lihat Detail
                                    </a>
                                    <form action="{{ route('approval.iduka.approve', $jurnal->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
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
                                <form action="{{ route('approval.reject', $jurnal->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Alasan Penolakan</label>
                                            <textarea class="form-control" name="rejected_reason" rows="3" required></textarea>
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
            </div>
        @endif
    </div>
</div>
@endsection
