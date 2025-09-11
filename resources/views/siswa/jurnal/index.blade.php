@extends('layout.main')

@section('content')
    <style>
        .journal-header {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .journal-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #667eea20, #764ba220);
            border-radius: 50%;
            transform: translate(50px, -50px);
        }

        .welcome-text {
            font-size: 28px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .subtitle {
            color: #718096;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .add-entry-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .add-entry-btn:hover {
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }

        .journal-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 30px;
        }

        .journal-grid {
            display: grid;
            gap: 20px;
        }

        .journal-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            transition: all 0.3s;
            position: relative;
        }

        .journal-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            border-color: #667eea;
        }

        .journal-date {
            font-size: 14px;
            color: #667eea;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .journal-subject {
            font-size: 18px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 12px;
        }

        .journal-content {
            color: #4a5568;
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .journal-tags {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .tag {
            background: #edf2f7;
            color: #4a5568;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .tag.learning {
            background: #e6fffa;
            color: #047857;
        }

        .tag.task {
            background: #fef3c7;
            color: #92400e;
        }

        .tag.reflection {
            background: #e0e7ff;
            color: #3730a3;
        }

        .tag.prakerin {
            background: #fce7f3;
            color: #be185d;
        }

        .journal-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-view {
            background: #e0e7ff;
            color: #3730a3;
        }

        .btn-edit {
            background: #fef3c7;
            color: #92400e;
        }

        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            text-decoration: none;
        }

        .btn-view:hover {
            color: #3730a3;
        }

        .btn-edit:hover {
            color: #92400e;
        }

        .btn-delete:hover {
            color: #dc2626;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #718096;
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .filter-section {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 1px solid #e2e8f0;
            background: white;
            color: #4a5568;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .filter-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .filter-btn:hover {
            border-color: #667eea;
            color: #667eea;
            text-decoration: none;
        }

        .filter-btn.active:hover {
            color: white;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            border-bottom: none;
            padding: 20px 30px;
        }

        .modal-title {
            font-weight: 700;
            font-size: 20px;
        }

        .modal-body {
            padding: 30px;
        }

        .modal-footer {
            border-top: 1px solid #e2e8f0;
            padding: 20px 30px;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }

        .journal-image {
            width: 100%;
            border-radius: 8px;
            margin-top: 10px;
            max-height: 200px;
            object-fit: cover;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .journal-header {
                padding: 20px;
            }

            .welcome-text {
                font-size: 24px;
            }

            .journal-section {
                padding: 20px;
            }

            .journal-actions {
                justify-content: center;
            }

            .modal-body {
                padding: 20px;
            }
        }
    </style>

    <!-- Header Section -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="journal-header">
            <div class="welcome-text">
                Jurnal Siswa 📖
            </div>
            <div class="subtitle">
                Catatan pembelajaran dan aktivitas harian Anda
            </div>
            <button type="button" class="add-entry-btn" data-bs-toggle="modal" data-bs-target="#createJournalModal">
                + Tambah Jurnal Baru
            </button>
        </div>

        <!-- Journal Section -->
        <div class="journal-section">
            <h2 class="section-title">Jurnal PKL</h2>
            <div class="journal-detail">
    <div class="journal-date">
        {{ \Carbon\Carbon::parse($jurnal->tgl)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
    </div>
    <div style="display: flex; gap: 15px; margin-bottom: 15px; font-size: 14px; color: #718096;">
        <span>🕐 {{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}</span>
        @if ($jurnal->foto)
            <span>📷 Dengan foto</span>
        @endif
    </div>
    <div class="journal-content">
        {{ $jurnal->uraian }}
    </div>
    @if ($jurnal->foto)
        <div class="mt-3">
            <img src="{{ $jurnal->foto }}" alt="Foto Kegiatan" class="journal-image">
        </div>
    @endif
    <div class="journal-tags mt-3">
        @if ($jurnal->validasi_pembimbing == 'sudah')
            <span class="tag" style="background: #d1fae5; color: #065f46;">✅ Disetujui Pembimbing</span>
        @else
            <span class="tag" style="background: #fef3c7; color: #92400e;">⏳ Menunggu Pembimbing</span>
        @endif
        @if ($jurnal->validasi_iduka == 'sudah')
            <span class="tag" style="background: #d1fae5; color: #065f46;">✅ Disetujui IDUKA</span>
        @else
            <span class="tag" style="background: #fef3c7; color: #92400e;">⏳ Menunggu IDUKA</span>
        @endif
    </div>
</div>
            {{-- Pagination --}}
            @if ($jurnals && method_exists($jurnals, 'links'))
                <div class="mt-4">
                    {{ $jurnals->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Create Journal Modal -->
    <div class="modal fade" id="createJournalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jurnal Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('jurnal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tgl"
                                        value="{{ old('tgl', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Foto Kegiatan</label>
                                    <input type="file" class="form-control" name="foto" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Jam Mulai</label>
                                    <input type="time" class="form-control" name="jam_mulai"
                                        value="{{ old('jam_mulai') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Jam Selesai</label>
                                    <input type="time" class="form-control" name="jam_selesai"
                                        value="{{ old('jam_selesai') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Uraian Kegiatan</label>
                            <textarea class="form-control" name="uraian" rows="5" required>{{ old('uraian') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Jurnal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Journal Modal -->
    <div class="modal fade" id="viewJournalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Jurnal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewJournalContent">
                    <!-- Content will be loaded via AJAX -->
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Journal Modal -->
    <div class="modal fade" id="editJournalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jurnal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editJournalForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" id="editJournalContent">
                        <!-- Content will be loaded via AJAX -->
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update Jurnal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

   <script>
    document.addEventListener('DOMContentLoaded', function() {
    // JavaScript untuk menangani modal view
    const viewJournalModal = document.getElementById('viewJournalModal');
    viewJournalModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const journalId = button.getAttribute('data-id');
        
        // Reset content
        document.getElementById('viewJournalContent').innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        
        // Load content via AJAX
        const url = `{{ route('jurnal.show', ['jurnal' => ':id']) }}`.replace(':id', journalId);
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('viewJournalContent').innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('viewJournalContent').innerHTML = `
                <div class="alert alert-danger">
                    <h6>Error</h6>
                    <p>Tidak dapat memuat detail jurnal. Silakan coba lagi.</p>
                </div>
            `;
        });
    });

    // JavaScript untuk menangani modal edit
    const editJournalModal = document.getElementById('editJournalModal');
    editJournalModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const journalId = button.getAttribute('data-id');
        
        // Set form action
        document.getElementById('editJournalForm').action = `{{ route('jurnal.update', ['jurnal' => ':id']) }}`.replace(':id', journalId);
        
        // Reset content
        document.getElementById('editJournalContent').innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        
        // Load content via AJAX
        const url = `{{ route('jurnal.edit', ['jurnal' => ':id']) }}`.replace(':id', journalId);
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(data => {
            document.getElementById('editJournalContent').innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('editJournalContent').innerHTML = `
                <div class="alert alert-danger">
                    <h6>Error</h6>
                    <p>Tidak dapat memuat form edit. Silakan coba lagi.</p>
                </div>
            `;
        });
    });
});
   </script>
@endsection