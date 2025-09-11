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

            @if ($jurnals->count() > 0)
                <div class="journal-grid">
                    @foreach ($jurnals as $jurnal)
                        <div class="journal-card">
                            <div class="journal-date">
                                {{ \Carbon\Carbon::parse($jurnal->tgl)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                            </div>
                            <div class="journal-subject">Kegiatan Harian</div>
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
                                @elseif ($jurnal->status === 'approved_iduka')
                                    <span class="tag" style="background: #e0e7ff; color: #3730a3;">✅ Disetujui
                                        IDUKA</span>
                                @elseif ($jurnal->status === 'approved_pembimbing')
                                    <span class="tag" style="background: #e0e7ff; color: #3730a3;">✅ Disetujui
                                        Pembimbing</span>
                                @elseif ($jurnal->status === 'approved')
                                    <span class="tag" style="background: #d1fae5; color: #065f46;">✅ Disetujui</span>
                                @elseif ($jurnal->status === 'rejected')
                                    <span class="tag" style="background: #fee2e2; color: #dc2626;">❌ Ditolak</span>
                                    <small class="text-muted">Alasan: {{ $jurnal->rejected_reason }}</small>
                                @endif
                            </div>
                            <div class="journal-actions">
                                <button type="button" class="action-btn btn-view" data-bs-toggle="modal"
                                    data-bs-target="#viewJournalModal" data-id="{{ $jurnal->id }}">
                                    Lihat Detail
                                </button>
                                <button type="button" class="action-btn btn-edit" data-bs-toggle="modal"
                                    data-bs-target="#editJournalModal" data-id="{{ $jurnal->id }}">
                                    Edit
                                </button>
                                <form action="{{ route('jurnal.destroy', $jurnal->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus jurnal ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">📝</div>
                    <h4>Belum ada jurnal</h4>
                    <p>Mulai tambah jurnal harian Anda untuk mencatat aktivitas PKL.</p>
                    <button type="button" class="add-entry-btn mt-3" data-bs-toggle="modal"
                        data-bs-target="#createJournalModal">
                        + Tambah Jurnal Baru
                    </button>
                </div>
            @endif

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
                    <h5 class="modal-title text-white">Detail Jurnal</h5>
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
            // Menambahkan CSRF token ke header AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Validasi form create
            const createForm = document.querySelector('#createJournalModal form');
            if (createForm) {
                createForm.addEventListener('submit', function(e) {
                    // Validasi jam selesai harus setelah jam mulai
                    const jamMulai = document.querySelector('input[name="jam_mulai"]').value;
                    const jamSelesai = document.querySelector('input[name="jam_selesai"]').value;

                    if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
                        e.preventDefault();
                        alert('Jam selesai harus setelah jam mulai.');
                        return false;
                    }
                });
            }

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
                const url = `/jurnal/${journalId}`;

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            if (response.status === 403) {
                                throw new Error('Unauthorized access');
                            }
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
                        <p>${error.message || 'Tidak dapat memuat detail jurnal. Silakan coba lagi.'}</p>
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
                document.getElementById('editJournalForm').action = `/jurnal/${journalId}`;

                // Reset content
                document.getElementById('editJournalContent').innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;

                // Load content via AJAX
                const url = `/jurnal/${journalId}/edit`;

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            if (response.status === 403) {
                                throw new Error('Unauthorized access');
                            }
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(data => {
                        document.getElementById('editJournalContent').innerHTML = data;

                        // Tambahkan validasi client-side setelah form dimuat
                        const jamMulaiInput = document.querySelector(
                            '#editJournalContent input[name="jam_mulai"]');
                        const jamSelesaiInput = document.querySelector(
                            '#editJournalContent input[name="jam_selesai"]');

                        if (jamMulaiInput && jamSelesaiInput) {
                            jamSelesaiInput.addEventListener('change', function() {
                                if (jamMulaiInput.value && this.value && this.value <=
                                    jamMulaiInput.value) {
                                    this.setCustomValidity(
                                        'Jam selesai harus setelah jam mulai');
                                } else {
                                    this.setCustomValidity('');
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('editJournalContent').innerHTML = `
                    <div class="alert alert-danger">
                        <h6>Error</h6>
                        <p>${error.message || 'Tidak dapat memuat form edit. Silakan coba lagi.'}</p>
                    </div>
                `;
                    });
            });

            // Menangani submit form edit
            document.getElementById('editJournalForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const url = form.action;

                // Validasi client-side untuk jam selesai
                const jamMulai = formData.get('jam_mulai');
                const jamSelesai = formData.get('jam_selesai');

                if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
                    alert('Jam selesai harus setelah jam mulai.');
                    return false;
                }

                // Disable submit button to prevent double submission
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                submitBtn.disabled = true;
                submitBtn.textContent = 'Memproses...';

                fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        // Check if response is ok
                        if (!response.ok) {
                            // Try to get error message from response
                            return response.text().then(text => {
                                throw new Error(
                                    `HTTP ${response.status}: ${text || 'Unknown error'}`);
                            });
                        }

                        // Check if response is JSON
                        const contentType = response.headers.get("content-type");
                        if (contentType && contentType.indexOf("application/json") !== -1) {
                            return response.json();
                        } else {
                            // If not JSON, assume success and reload
                            return {
                                success: true
                            };
                        }
                    })
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            alert('Jurnal berhasil diperbarui!');

                            // Close modal and reload page
                            $('#editJournalModal').modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        } else {
                            // Menampilkan error validasi khusus
                            if (data.errors && data.errors.jam_selesai) {
                                throw new Error(data.errors.jam_selesai[0]);
                            }
                            throw new Error(data.message || 'Terjadi kesalahan saat mengupdate jurnal');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        // Show specific error message
                        let errorMessage = 'Terjadi kesalahan saat mengupdate jurnal.';

                        if (error.message.includes('jam selesai') || error.message.includes('after')) {
                            errorMessage = 'Jam selesai harus setelah jam mulai.';
                        } else if (error.message.includes('422')) {
                            errorMessage = 'Data yang dimasukkan tidak valid. Silakan periksa kembali.';
                        } else if (error.message.includes('403')) {
                            errorMessage = 'Anda tidak memiliki akses untuk mengupdate jurnal ini.';
                        } else if (error.message.includes('500')) {
                            errorMessage = 'Terjadi kesalahan server. Silakan coba lagi.';
                        } else {
                            errorMessage = error.message;
                        }

                        alert(errorMessage);
                    })
                    .finally(() => {
                        // Re-enable submit button
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    });
            });

            // Validasi real-time untuk form create
            const jamMulaiCreate = document.querySelector('#createJournalModal input[name="jam_mulai"]');
            const jamSelesaiCreate = document.querySelector('#createJournalModal input[name="jam_selesai"]');

            if (jamSelesaiCreate) {
                jamSelesaiCreate.addEventListener('change', function() {
                    if (jamMulaiCreate.value && this.value && this.value <= jamMulaiCreate.value) {
                        this.setCustomValidity('Jam selesai harus setelah jam mulai');
                    } else {
                        this.setCustomValidity('');
                    }
                });
            }
        });
    </script>
@endsection
