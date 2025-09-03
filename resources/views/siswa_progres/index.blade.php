@extends('layout.main')

@section('content')
    <div class="container py-4">

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form method="GET" action="{{ route('progres.siswa.index') }}">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold text-muted small">Nama Iduka</label>
                                            <input type="text" name="nama_iduka" value="{{ request('nama_iduka') }}"
                                                class="form-control" placeholder="Cari Nama Iduka">
                                        </div>
                                        <div class="col-md-3 d-flex align-items-end gap-2">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fas fa-search me-2"></i>Search
                                            </button>
                                            <a href="{{ route('progres.siswa.index') }}" class="btn btn-secondary w-100">
                                                <i class="fas fa-sync-alt me-2"></i>Reset
                                            </a>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title fw-bold mb-0">👨‍🎓 Daftar Siswa</h5>
                            <div class="col-lg-4">
                                <div class="d-flex gap-2 justify-content-lg-end mt-3 mt-lg-0">
                                    <a href="{{ route('progres.siswa.export') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
                                        class="btn btn-outline-success">
                                        <i class="fas fa-file-excel me-1"></i>
                                        Export Semua
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="siswaTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 fw-semibold text-muted small px-4 py-3">NO</th>
                                        <th class="border-0 fw-semibold text-muted small py-3">NAMA SISWA</th>
                                        <th class="border-0 fw-semibold text-muted small py-3">KELAS</th>
                                        <th class="border-0 fw-semibold text-muted small py-3">JURUSAN</th>
                                        <th class="border-0 fw-semibold text-muted small py-3">Nama Iduka</th>
                                        <th class="border-0 fw-semibold text-muted small py-3">STATUS USULAN</th>
                                        <th class="border-0 fw-semibold text-muted small py-3">STATUS SURAT USULAN</th>
                                        <th class="border-0 fw-semibold text-muted small py-3">STATUS PENGAJUAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($siswa as $index => $row)
                                        <tr>
                                            <td class="px-4">{{ $index + 1 }}</td>
                                            <td>{{ $row->nama_siswa }}</td>
                                            <td>{{ $row->kelas }}</td>
                                            <td>{{ $row->jurusan }}</td>
                                            <td>{{ $row->nama_iduka ?? '-' }}</td>
                                            <td>
                                                <div class="text-center">
                                                    @if ($row->status_usulan == 'diterima')
                                                        <span class="badge bg-success">{{ $row->status_usulan }}</span>
                                                    @elseif($row->status_usulan == 'ditolak')
                                                        <span class="badge bg-danger">{{ $row->status_usulan }}</span>
                                                    @elseif($row->status_usulan == 'proses')
                                                        <span class="badge bg-warning">{{ $row->status_usulan }}</span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary">{{ $row->status_usulan ?? '-' }}</span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td>
                                                <div class="text-center">
                                                    @if ($row->status_surat_usulan == 'sudah')
                                                        <span
                                                            class="badge bg-success">{{ $row->status_surat_usulan }}</span>
                                                    @elseif($row->status_surat_usulan == 'belum')
                                                        <span
                                                            class="badge bg-danger">{{ $row->status_surat_usulan }}</span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary ">{{ $row->status_surat_usulan ?? '-' }}</span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td>
                                                <div class="text-center">
                                                    @if ($row->status_pengajuan == 'diterima')
                                                        <span class="badge bg-success">{{ $row->status_pengajuan }}</span>
                                                    @elseif($row->status_pengajuan == 'ditolak')
                                                        <span class="badge bg-danger">{{ $row->status_pengajuan }}</span>
                                                    @elseif($row->status_pengajuan == 'proses')
                                                        <span class="badge bg-warning">{{ $row->status_pengajuan }}</span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary">{{ $row->status_pengajuan ?? '-' }}</span>
                                                    @endif
                                                </div>
                                        </tr>
                                    @endforeach
                                    <!-- Data lainnya akan diisi dari database -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete(id) {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/siswa/${id}`;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Auto hide alerts
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
@endpush

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .card-hover {
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.03);
    }

    .animate-counter {
        transition: all 0.6s ease;
    }

    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .card {
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .form-select,
    .form-control {
        border-radius: 8px;
        border: 1px solid #e3e6f0;
        transition: all 0.3s ease;
    }

    .form-select:focus,
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    canvas {
        border-radius: 8px;
    }

    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    @keyframes pulse {
        0% {
            opacity: 0.8;
        }

        50% {
            opacity: 1;
        }

        100% {
            opacity: 0.8;
        }
    }

    .pulse-animation {
        animation: pulse 2s infinite;
    }

    /* Custom styling for avatar circles */
    .rounded-circle {
        font-size: 16px;
    }

    /* Status badges styling */
    .badge {
        padding: 6px 10px;
        font-size: 0.75rem;
    }

    /* Action buttons styling */
    .btn-sm {
        padding: 0.375rem 0.5rem;
        font-size: 0.875rem;
    }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
