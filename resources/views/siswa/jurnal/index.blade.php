@extends('layout.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
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
                            <h5 class="mb-0 fw-bold">Jurnal PKL</h5>
                            <button class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#createJournalModal">
                                <i class="bi bi-plus-circle me-1"></i>
                                Tambah Jurnal
                            </button>
                        </div>

                        <!-- List jurnal aktif -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Pengetahuan Baru</th>
                                        <th>Dalam Mapel</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($activeJurnals as $jurnal)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($jurnal->tgl)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                            </td>
                                            <td>{{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}</td>
                                            <td class="text-center">
                                                @if ($jurnal->is_pengetahuan_baru)
                                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                                @else
                                                    <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($jurnal->is_dalam_mapel)
                                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                                @else
                                                    <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($jurnal->status === 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Menunggu Validasi</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button type="button" class="btn btn-sm btn-info shadow-sm"
                                                        onclick="showJournalDetail({{ $jurnal->id }})"
                                                        title="Lihat Detail">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-warning shadow-sm"
                                                        onclick="alert('Fitur sedang diperbaiki, silakan coba lagi nanti.')"
                                                        title="Edit (sementara tidak dapat diakses)">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-sm btn-danger shadow-sm"
                                                        onclick="confirmDelete({{ $jurnal->id }})" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <i class="bi bi-journal-text text-muted" style="font-size: 4rem;"></i>
                                                <p class="mt-3 text-muted">Belum ada jurnal aktif</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab Riwayat -->
                    <div class="tab-pane fade" id="tab-riwayat" role="tabpanel">
                        <h5 class="mb-4 fw-bold">Riwayat Jurnal</h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Pengetahuan Baru</th>
                                        <th>Dalam Mapel</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($historyJurnals as $jurnal)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($jurnal->tgl)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                            </td>
                                            <td>{{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}</td>
                                            <td class="text-center">
                                                @if ($jurnal->is_pengetahuan_baru)
                                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                                @else
                                                    <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($jurnal->is_dalam_mapel)
                                                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                                @else
                                                    <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-success">Disetujui</span>
                                                @if ($jurnal->approved_by)
                                                    <small class="text-muted d-block">Oleh:
                                                        {{ $jurnal->approved_by }}</small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-info shadow-sm"
                                                    onclick="showJournalDetail({{ $jurnal->id }})" title="Lihat Detail">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <i class="bi bi-clock-history text-muted" style="font-size: 4rem;"></i>
                                                <p class="mt-3 text-muted">Belum ada riwayat jurnal</p>
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
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Jurnal Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('jurnal.store') }}" method="POST" enctype="multipart/form-data"
                    id="createJournalForm">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-uppercase small text-muted mb-2">
                                    <i class="bi bi-calendar3 me-1"></i>Tanggal
                                </label>
                                <input type="date" class="form-control form-control-lg" name="tgl"
                                    value="{{ old('tgl', date('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-uppercase small text-muted mb-2">
                                    <i class="bi bi-image me-1"></i>Foto Kegiatan
                                </label>
                                <input type="file" class="form-control form-control-lg" name="foto"
                                    accept="image/*" id="createFotoInput">
                                <small class="text-muted">Format: JPG, PNG, GIF (Max: 2MB)</small>
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-uppercase small text-muted mb-2">
                                    <i class="bi bi-clock me-1"></i>Jam Mulai
                                </label>
                                <input type="time" class="form-control form-control-lg" name="jam_mulai"
                                    value="{{ old('jam_mulai') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-uppercase small text-muted mb-2">
                                    <i class="bi bi-clock-history me-1"></i>Jam Selesai
                                </label>
                                <input type="time" class="form-control form-control-lg" name="jam_selesai"
                                    value="{{ old('jam_selesai') }}" required>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label fw-semibold text-uppercase small text-muted mb-2">
                                <i class="bi bi-file-text me-1"></i>Uraian Kegiatan
                            </label>
                            <textarea class="form-control form-control-lg" name="uraian" rows="5"
                                placeholder="Tuliskan uraian kegiatan yang dilakukan..." required>{{ old('uraian') }}</textarea>
                            <small class="text-muted">Maksimal 1000 karakter</small>
                        </div>

                        <div class="mt-4 p-3 bg-light rounded">
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" name="is_pengetahuan_baru"
                                    id="is_pengetahuan_baru" value="1"
                                    {{ old('is_pengetahuan_baru') ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_pengetahuan_baru">
                                    <i class="bi bi-lightbulb-fill text-warning me-1"></i>
                                    Termasuk pengetahuan baru
                                </label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="is_dalam_mapel"
                                    id="is_dalam_mapel" value="1" {{ old('is_dalam_mapel') ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_dalam_mapel">
                                    <i class="bi bi-book-fill text-primary me-1"></i>
                                    Kegiatan ada dalam mapel sekolah
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-save me-1"></i>Simpan Jurnal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Journal Modal -->
    <div class="modal fade" id="viewJournalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-eye me-2"></i>Detail Jurnal
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="journalDetailContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Journal Modal -->
    <div class="modal fade" id="editJournalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-pencil-square me-2"></i>Edit Jurnal
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editJournalForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4" id="editJournalContent">
                        <!-- Content will be loaded via AJAX -->
                        <div class="text-center py-5">
                            <div class="spinner-border text-warning" role="status" style="width: 3rem; height: 3rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3 text-muted">Memuat data jurnal...</p>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-warning text-dark px-4 shadow-sm fw-semibold">
                            <i class="bi bi-save me-1"></i>Update Jurnal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteJournalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white border-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-3">
                        <i class="bi bi-trash3-fill text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <p class="text-center mb-0 fs-5">Apakah Anda yakin ingin menghapus jurnal ini?</p>
                    <p class="text-center text-muted mt-2">Data yang dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <form id="deleteJournalForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4 shadow-sm fw-semibold">
                            <i class="bi bi-trash3 me-1"></i>Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }

        .modal-header {
            padding: 1.25rem 1.5rem;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }

        .form-control-lg {
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }

        .btn {
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .badge {
            padding: 0.5rem 0.75rem;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }

        .shadow {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .form-check-input:checked {
            background-color: #6366f1;
            border-color: #6366f1;
        }

        .card {
            border-radius: 10px;
            border: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menambahkan CSRF token ke header AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Validasi form create
            const createForm = document.getElementById('createJournalForm');
            if (createForm) {
                createForm.addEventListener('submit', function(e) {
                    const jamMulai = this.querySelector('input[name="jam_mulai"]').value;
                    const jamSelesai = this.querySelector('input[name="jam_selesai"]').value;

                    if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian!',
                            text: 'Jam selesai harus lebih dari jam mulai.',
                            confirmButtonColor: '#6366f1'
                        });
                        return false;
                    }
                });
            }

            // Function to show journal detail
            window.showJournalDetail = function(id) {
                const modal = new bootstrap.Modal(document.getElementById('viewJournalModal'));
                const modalBody = document.getElementById('journalDetailContent');

                modalBody.innerHTML = `
                    <div class="text-center py-5">
                        <div class="spinner-border text-info" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Memuat detail jurnal...</p>
                    </div>
                `;

                modal.show();

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

            // Function to edit journal
            window.editJournal = function(id) {
                const modal = new bootstrap.Modal(document.getElementById('editJournalModal'));
                const modalBody = document.getElementById('editJournalContent');
                const form = document.getElementById('editJournalForm');

                modalBody.innerHTML = `
                    <div class="text-center py-5">
                        <div class="spinner-border text-warning" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Memuat data jurnal...</p>
                    </div>
                `;

                form.action = `/jurnal/${id}`;
                modal.show();

                fetch(`/jurnal/${id}/edit`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        modalBody.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        modalBody.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Gagal memuat data jurnal. Silakan coba lagi.
                            <button onclick="editJournal(${id})" class="btn btn-sm btn-outline-danger mt-2 d-block">
                                <i class="bi bi-arrow-clockwise me-1"></i>Coba Lagi
                            </button>
                        </div>
                    `;
                    });
            };

            // PERBAIKAN: Validasi dan kirim form edit via AJAX
            const editForm = document.getElementById('editJournalForm');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    e.preventDefault(); // Cegah pengiriman form default

                    const jamMulai = this.querySelector('input[name="jam_mulai"]').value;
                    const jamSelesai = this.querySelector('input[name="jam_selesai"]').value;

                    if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian!',
                            text: 'Jam selesai harus lebih dari jam mulai.',
                            confirmButtonColor: '#6366f1'
                        });
                        return false;
                    }

                    // Siapkan data untuk dikirim via AJAX
                    const formData = new FormData(this);
                    const submitButton = this.querySelector('button[type="submit"]');
                    const originalButtonText = submitButton.innerHTML;

                    // Tampilkan indikator loading
                    submitButton.disabled = true;
                    submitButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...';

                    // Debug: Log form data
                    console.log('Submitting form with data:');
                    for (let pair of formData.entries()) {
                        console.log(pair[0] + ': ' + pair[1]);
                    }

                    fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => {
                            // Debug: Log response status
                            console.log('Response status:', response.status);

                            // Jika response adalah redirect, itu berarti berhasil
                            if (response.redirected) {
                                return {
                                    success: true,
                                    redirect: response.url
                                };
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Debug: Log response data
                            console.log('Response data:', data);

                            if (data.success || data.redirect) {
                                // Tutup modal
                                const modal = bootstrap.Modal.getInstance(document.getElementById(
                                    'editJournalModal'));
                                modal.hide();

                                // Tampilkan pesan sukses
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Jurnal berhasil diperbarui.',
                                    confirmButtonColor: '#6366f1',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    // Muat ulang halaman untuk menampilkan data yang diperbarui
                                    window.location.reload();
                                });
                            } else {
                                // Tangani error validasi atau error lainnya
                                let errorMessage = 'Terjadi kesalahan saat memperbarui jurnal.';
                                if (data.message) {
                                    errorMessage = data.message;
                                } else if (data.errors) {
                                    // Tampilkan error validasi spesifik
                                    const firstError = Object.values(data.errors)[0][0];
                                    errorMessage = firstError;
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: errorMessage,
                                    confirmButtonColor: '#6366f1'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
                                confirmButtonColor: '#6366f1'
                            });
                        })
                        .finally(() => {
                            // Kembalikan tombol ke keadaan semula
                            submitButton.disabled = false;
                            submitButton.innerHTML = originalButtonText;
                        });
                });
            }

            // Function to confirm delete
            window.confirmDelete = function(id) {
                const modal = new bootstrap.Modal(document.getElementById('deleteJournalModal'));
                const form = document.getElementById('deleteJournalForm');
                form.action = `/jurnal/${id}`;
                modal.show();
            };

            // Handle tab persistence
            const hash = window.location.hash;
            if (hash) {
                const tab = document.querySelector(`[href="${hash}"]`);
                if (tab) {
                    new bootstrap.Tab(tab).show();
                }
            }

            // Update URL when tab changes
            document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(e) {
                    history.pushState(null, null, e.target.getAttribute('href'));
                });
            });
        });
    </script>
@endsection
