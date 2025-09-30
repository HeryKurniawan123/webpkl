@extends('layout.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab-jurnal" role="tab">
                            <i class="bi bi-journal-text me-1"></i>
                            Jurnal Aktif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-riwayat" role="tab">
                            <i class="bi bi-clock-history me-1"></i>
                            Riwayat
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">
                    <!-- Tab Jurnal Aktif -->
                    <div class="tab-pane fade show active" id="tab-jurnal" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Jurnal PKL</h5>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createJournalModal">
                                <i class="bi bi-plus-circle me-1"></i>
                                Tambah Jurnal
                            </button>
                        </div>

                        <!-- List jurnal aktif -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($activeJurnals as $jurnal)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($jurnal->tgl)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                            </td>
                                            <td>{{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}</td>
                                            <td>
                                                @if ($jurnal->status === 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @else
                                                    <span class="badge bg-warning">Menunggu Validasi</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="showJournalDetail({{ $jurnal->id }})">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4">
                                                <i class="bi bi-journal-text fs-1 text-muted"></i>
                                                <p class="mt-3">Belum ada jurnal aktif</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab Riwayat -->
                    <div class="tab-pane fade" id="tab-riwayat" role="tabpanel">
                        <h5 class="mb-4">Riwayat Jurnal</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($historyJurnals as $jurnal)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($jurnal->tgl)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                            </td>
                                            <td>{{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}</td>
                                            <td>
                                                <span class="badge bg-success">Disetujui</span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info"
                                                    onclick="showJournalDetail({{ $jurnal->id }})">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4">
                                                <i class="bi bi-clock-history fs-1 text-muted"></i>
                                                <p class="mt-3">Belum ada riwayat jurnal</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
    <!-- View Journal Modal -->
    <div class="modal fade" id="viewJournalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Jurnal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="journalDetailContent">
                    <!-- Content will be loaded here -->
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

        document.addEventListener('DOMContentLoaded', function() {
            // Handle tab persistence
            const hash = window.location.hash;
            if (hash) {
                const tab = document.querySelector(`[href="${hash}"]`);
                if (tab) {
                    new bootstrap.Tab(tab).show();
                }
            }

            // Function to show journal detail
            window.showJournalDetail = function(id) {
                const modal = new bootstrap.Modal(document.getElementById('viewJournalModal'));
                const modalBody = document.getElementById('journalDetailContent');

                // Show loading state
                modalBody.innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memuat detail jurnal...</p>
                    </div>
                `;

                modal.show();

                // Fetch journal detail
                fetch(`/jurnal/${id}/show`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        modalBody.innerHTML = data.data;
                    } else {
                        throw new Error(data.message || 'Failed to load journal details');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    modalBody.innerHTML = `
                        <div class="alert alert-danger m-3">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            ${error.message}
                            <button onclick="showJournalDetail(${id})" class="btn btn-sm btn-outline-danger mt-2 d-block">
                                <i class="bi bi-arrow-clockwise me-1"></i>Coba Lagi
                            </button>
                        </div>
                    `;
                });
            };

            // Update URL when tab changes
            document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(e) {
                    history.pushState(null, null, e.target.getAttribute('href'));
                });
            });
        });
    </script>
@endsection
