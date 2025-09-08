<!-- Modal Detail Siswa -->
<div class="modal fade" id="detailSiswaModal" tabindex="-1" aria-labelledby="detailSiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title text-white fw-bold" id="detailSiswaModalLabel">
                    <i class="fas fa-user-graduate me-2"></i>Profile Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-4 text-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=Ahmad+Fauzi&background=28a745&color=fff&size=120&rounded=true" alt="Profile" class="rounded-circle mb-3" style="width: 120px; height: 120px;">
                        <h5 class="fw-bold">Ahmad Fauzi</h5>
                        <p class="text-muted small">NIS. 2021240001</p>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-warning-subtle text-warning">Belum Ada Pembimbing</span>
                            <span class="badge bg-primary-subtle text-primary">XII RPL 1</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h6 class="fw-bold text-secondary mb-2">
                                <i class="fas fa-info-circle me-2"></i>Informasi Akademik
                            </h6>
                            <div class="row g-3">
                                <div class="col-6">
                                    <small class="text-muted">Kelas:</small>
                                    <div class="fw-semibold">XII RPL 1</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Rata-rata Nilai:</small>
                                    <div class="fw-semibold">85.5</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Ranking Kelas:</small>
                                    <div class="fw-semibold">5 dari 32</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Absensi:</small>
                                    <div class="fw-semibold">
                                        <i class="fas fa-check-circle text-success"></i> 96% Hadir
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold text-secondary mb-2">
                                <i class="fas fa-lightbulb me-2"></i>Minat & Bakat
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-primary-subtle text-primary px-3 py-2">Web Development</span>
                                <span class="badge bg-success-subtle text-success px-3 py-2">Mobile Application</span>
                                <span class="badge bg-info-subtle text-info px-3 py-2">UI/UX Design</span>
                                <span class="badge bg-warning-subtle text-warning px-3 py-2">Database</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold text-secondary mb-2">
                                <i class="fas fa-trophy me-2"></i>Prestasi
                            </h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-medal text-warning me-2"></i>
                                    Juara 2 Lomba Web Design Tingkat Kota 2023
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-certificate text-primary me-2"></i>
                                    Sertifikat HTML & CSS Foundation
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-award text-success me-2"></i>
                                    Best Student of The Month - Oktober 2023
                                </li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold text-secondary mb-2">
                                <i class="fas fa-project-diagram me-2"></i>Project yang Dikerjakan
                            </h6>
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="border rounded-3 p-3">
                                        <h6 class="fw-semibold mb-1">Sistem Informasi Perpustakaan</h6>
                                        <small class="text-muted">Web Application - PHP, MySQL, Bootstrap</small>
                                        <div class="mt-2">
                                            <span class="badge bg-success-subtle text-success">Completed</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="border rounded-3 p-3">
                                        <h6 class="fw-semibold mb-1">E-Commerce Mobile App</h6>
                                        <small class="text-muted">Mobile Application - Flutter, Firebase</small>
                                        <div class="mt-2">
                                            <span class="badge bg-warning-subtle text-warning">In Progress</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
                <button type="button" class="btn btn-success" style="border-radius: 10px; background: linear-gradient(45deg, #28a745, #20c997);">
                    <i class="fas fa-user-plus me-2"></i>Pilih sebagai Siswa Bimbingan
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.bg-purple-subtle {
    background-color: rgba(102, 126, 234, 0.1) !important;
}
.text-purple {
    color: #667eea !important;
}

.card:hover {
    transition: all 0.3s ease;
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.form-control:focus,
.form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    border: none;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
}

.page-link {
    border: 1px solid #dee2e6;
    margin: 0 2px;
}

.page-item.active .page-link {
    border: none;
}

.modal-content {
    border: none;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
}

.btn-check:checked + .btn-outline-light {
    background-color: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
}

.btn-outline-light:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.3);
}

@media (max-width: 768px) {
    .btn-group {
        width: 100%;
        margin-top: 1rem;
    }
    
    .btn-group .btn {
        flex: 1;
    }
    
    .card-body .row.text-center.g-2 .col-4 {
        margin-bottom: 0.5rem;
    }
}

/* JavaScript untuk Toggle Mode */
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewSiswa = document.getElementById('viewSiswa');
    const viewGuru = document.getElementById('viewGuru');
    const filterSiswa = document.getElementById('filterSiswa');
    const filterGuru = document.getElementById('filterGuru');
    const contentSiswa = document.getElementById('contentSiswa');
    const contentGuru = document.getElementById('contentGuru');

    viewSiswa.addEventListener('change', function() {
        if (this.checked) {
            filterSiswa.style.display = 'block';
            filterGuru.style.display = 'none';
            contentSiswa.style.display = 'flex';
            contentGuru.style.display = 'none';
        }
    });

    viewGuru.addEventListener('change', function() {
        if (this.checked) {
            filterSiswa.style.display = 'none';
            filterGuru.style.display = 'block';
            contentSiswa.style.display = 'none';
            contentGuru.style.display = 'flex';
        }
    });
});
</script>@extends('layout.main')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px;">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="text-white mb-2 fw-bold">
                                <i class="fas fa-user-tie me-3"></i>Penentuan Pembimbing
                            </h2>
                            <p class="text-white-50 mb-0 fs-6">
                                Pilih pembimbing yang sesuai dengan keahlian dan program studi Anda
                            </p>
                        </div>
                        <div class="col-md-4 text-end d-none d-md-block">
                            <div class="position-relative">
                                <i class="fas fa-users text-white opacity-25" style="font-size: 4rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter dan Search Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-secondary">
                                <i class="fas fa-star me-2"></i>Status Ketersediaan
                            </label>
                            <select class="form-select" style="border-radius: 10px; border: 2px solid #e9ecef;">
                                <option selected>Semua Status</option>
                                <option value="tersedia">Tersedia</option>
                                <option value="terbatas">Terbatas</option>
                                <option value="penuh">Penuh</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button class="btn btn-primary" style="border-radius: 10px; background: linear-gradient(45deg, #667eea, #764ba2);">
                                    <i class="fas fa-filter me-2"></i>Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Pembimbing -->
    <div class="row">
        <!-- Pembimbing Card 1 -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <div class="position-relative d-inline-block">
                            <img src="https://ui-avatars.com/api/?name=Drs+Ahmad+Wijaya&background=667eea&color=fff&size=80&rounded=true" alt="Profile" class="rounded-circle mb-2" style="width: 80px; height: 80px;">
                            <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-1" style="width: 20px; height: 20px;">
                                <span class="visually-hidden">Online</span>
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Drslili</h5>
                        <p class="text-muted small mb-0">NIP. 196512101990031008</p>
                    </div>
                    
                    <div class="mb-3">
                        <div class="row text-center g-2">
                            <div class="col-4">
                                <div class="bg-light rounded-3 p-2">
                                    <i class="fas fa-graduation-cap text-primary mb-1 d-block"></i>
                                    <small class="text-muted">RPL</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-light rounded-3 p-2">
                                    <i class="fas fa-users text-success mb-1 d-block"></i>
                                    <small class="text-muted">8/15</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-light rounded-3 p-2">
                                    <i class="fas fa-star text-warning mb-1 d-block"></i>
                                    <small class="text-muted">4.8</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="mb-3">
                        <h6 class="fw-semibold text-secondary mb-2">
                            <i class="fas fa-cogs me-2"></i>Keahlian:
                        </h6>
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge bg-primary-subtle text-primary rounded-pill">Web Development</span>
                            <span class="badge bg-success-subtle text-success rounded-pill">Database</span>
                            <span class="badge bg-info-subtle text-info rounded-pill">Mobile App</span>
                        </div>
                    </div> --}}

                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" style="border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#detailModal">
                            <i class="fas fa-eye me-2"></i>Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true" style="border-radius: 10px;">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#" style="border-radius: 10px; background: linear-gradient(45deg, #667eea, #764ba2);">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#" style="border-radius: 10px;">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#" style="border-radius: 10px;">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#" style="border-radius: 10px;">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Modal Detail Pembimbing -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title text-white fw-bold" id="detailModalLabel">
                    <i class="fas fa-user-tie me-2"></i>Detail Pembimbing
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-4 text-center mb-4">
                        <img src="https://ui-avatars.com/api/?name=Drs+Ahmad+Wijaya&background=667eea&color=fff&size=120&rounded=true" alt="Profile" class="rounded-circle mb-3" style="width: 120px; height: 120px;">
                        <h5 class="fw-bold">Drs. Ahmad Wijaya, M.Pd</h5>
                        <p class="text-muted small">NIP. 196512101990031008</p>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-success-subtle text-success">Tersedia</span>
                            <span class="badge bg-primary-subtle text-primary">RPL</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h6 class="fw-bold text-secondary mb-2">
                                <i class="fas fa-info-circle me-2"></i>Informasi Lengkap
                            </h6>
                            <div class="row g-3">
                                <div class="col-6">
                                    <small class="text-muted">Program Studi:</small>
                                    <div class="fw-semibold">Rekayasa Perangkat Lunak</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Pengalaman:</small>
                                    <div class="fw-semibold">15 Tahun</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Siswa Dibimbing:</small>
                                    <div class="fw-semibold">8 / 15 Siswa</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Rating:</small>
                                    <div class="fw-semibold">
                                        <i class="fas fa-star text-warning"></i> 4.8/5.0
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold text-secondary mb-2">
                                <i class="fas fa-cogs me-2"></i>Bidang Keahlian
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-primary-subtle text-primary px-3 py-2">Web Development</span>
                                <span class="badge bg-success-subtle text-success px-3 py-2">Database Management</span>
                                <span class="badge bg-info-subtle text-info px-3 py-2">Mobile Application</span>
                                <span class="badge bg-warning-subtle text-warning px-3 py-2">System Analysis</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-success" style="border-radius: 10px;" data-bs-toggle="dropdown">
                        <i class="fas fa-plus me-2"></i>Tambah ke Bimbingan
                    </button>
                    <div class="dropdown-menu p-3" style="min-width: 300px; border-radius: 10px;">
                        <h6 class="dropdown-header fw-bold">
                            <i class="fas fa-users me-2"></i>Pilih Siswa untuk Dibimbing
                        </h6>
                        <div class="mb-2">
                            <select class="form-select form-select-sm">
                                <option selected>Pilih siswa...</option>
                                <option value="siswa1">Ahmad Fauzi - XII RPL 1 (NIS: 2021240001)</option>
                                <option value="siswa2">Siti Aisyah - XII RPL 1 (NIS: 2021240002)</option>
                                <option value="siswa3">Budi Santoso - XII RPL 1 (NIS: 2021240003)</option>
                                <option value="siswa4">Maya Putri - XII RPL 2 (NIS: 2021240004)</option>
                                <option value="siswa5">Rizky Pratama - XII RPL 2 (NIS: 2021240005)</option>
                            </select>
                        </div>
                        <button class="btn btn-success btn-sm w-100">
                            <i class="fas fa-plus me-2"></i>Konfirmasi Tambah
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-purple-subtle {
    background-color: rgba(102, 126, 234, 0.1) !important;
}
.text-purple {
    color: #667eea !important;
}

.card:hover {
    transition: all 0.3s ease;
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.form-control:focus,
.form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    border: none;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.page-link {
    border: 1px solid #dee2e6;
    margin: 0 2px;
}

.page-item.active .page-link {
    border: none;
}

.modal-content {
    border: none;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
}

@media (max-width: 768px) {
    .col-md-4.text-end {
        text-center: true;
        margin-top: 1rem;
    }
    
    .card-body .row.text-center.g-2 .col-4 {
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection