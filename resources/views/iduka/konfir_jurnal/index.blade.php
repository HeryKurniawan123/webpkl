@extends('layout.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="journal-header">
            <div class="welcome-text">
                Persetujuan Jurnal - IDUKA 📖
            </div>
            <div class="subtitle">
                Daftar jurnal yang membutuhkan persetujuan
            </div>
        </div>

        <div class="journal-section">
            <h2 class="section-title">Jurnal Menunggu Persetujuan</h2>

            @if ($jurnals->count() > 0)
                <div class="journal-grid">
                    @foreach ($jurnals as $jurnal)
                        <div class="journal-card">
                            <div class="journal-date">
                                {{ \Carbon\Carbon::parse($jurnal->tgl)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                            </div>
                            <div class="journal-subject">
                                Kegiatan Harian - {{ $jurnal->user ? $jurnal->user->name : 'User tidak ditemukan' }}
                            </div>
                            <div class="journal-content">
                                {{ Str::limit($jurnal->uraian, 150) }}
                            </div>
                            <div style="display: flex; gap: 15px; margin-bottom: 15px; font-size: 14px; color: #718096;">
                                <span>🕐 {{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}</span>
                                @if ($jurnal->foto)
                                    <span>📷 Dengan foto</span>
                                @endif
                            </div>
                            <div class="journal-tags">
                                @if ($jurnal->status === 'pending')
                                    <span class="tag" style="background: #fef3c7; color: #92400e;">⏳ Menunggu
                                        Persetujuan</span>
                                @elseif ($jurnal->status === 'approved_pembimbing')
                                    <span class="tag" style="background: #d1fae5; color: #065f46;">✅ Disetujui
                                        Pembimbing</span>
                                @endif
                            </div>
                            <div class="journal-actions">
                                <a href="{{ route('approval.show', $jurnal->id) }}" class="action-btn btn-view">
                                    Lihat Detail
                                </a>
                                <form action="{{ route('approval.iduka.approve', $jurnal->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn btn-edit">
                                        Setujui
                                    </button>
                                </form>
                                <button type="button" class="action-btn btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#rejectModal{{ $jurnal->id }}">
                                    Tolak
                                </button>
                            </div>
                        </div>

                        <!-- Modal Tolak -->
                        <div class="modal fade" id="rejectModal{{ $jurnal->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Alasan Penolakan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('approval.reject', $jurnal->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="form-label">Alasan Penolakan</label>
                                                <textarea class="form-control" name="rejected_reason" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Tolak Jurnal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">✅</div>
                    <h4>Tidak ada jurnal yang perlu disetujui</h4>
                    <p>Semua jurnal telah diproses.</p>
                </div>
            @endif

            {{ $jurnals->links() }}
        </div>
    </div>
@endsection
