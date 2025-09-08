@extends('layout.main')

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
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-secondary">
                                <i class="fas fa-search me-2"></i>Cari Pembimbing
                            </label>
                            <input type="text" class="form-control" placeholder="Nama pembimbing atau keahlian..." style="border-radius: 10px; border: 2px solid #e9ecef;">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-secondary">
                                <i class="fas fa-graduation-cap me-2"></i>Program Studi
                            </label>
                            <select class="form-select" style="border-radius: 10px; border: 2px solid #e9ecef;">
                                <option selected>Semua Program Studi</option>
                                <option value="rpl">Rekayasa Perangkat Lunak</option>
                                <option value="tkj">Teknik Komputer Jaringan</option>
                                <option value="mm">Multimedia</option>
                                <option value="akl">Akuntansi Keuangan Lembaga</option>
                            </select>
                        </div>
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
                                    <i class="fas fa-filter me-2"></i>Filter
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
                        <h5 class="fw-bold text-dark mb-1">Drs. Ahmad Wijaya, M.Pd</h5>
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

                    <div class="mb-3">
                        <h6 class="fw-semibold text-secondary mb-2">
                            <i class="fas fa-cogs me-2"></i>Keahlian:
                        </h6>
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge bg-primary-subtle text-primary rounded-pill">Web Development</span>
                            <span class="badge bg-success-subtle text-success rounded-pill">Database</span>
                            <span class="badge bg-info-subtle text-info rounded-pill">Mobile App</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" style="border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#detailModal">
                            <i class="fas fa-eye me-2"></i>Lihat Detail
                        </button>
                        <button class="btn btn-primary" style="border-radius: 10px; background: linear-gradient(45deg, #667eea, #764ba2);">
                            <i class="fas fa-user-plus me-2"></i>Pilih Pembimbing
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pembimbing Card 2 -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <div class="position-relative d-inline-block">
                            <img src="https://ui-avatars.com/api/?name=Dr+Siti+Nurhaliza&background=764ba2&color=fff&size=80&rounded=true" alt="Profile" class="rounded-circle mb-2" style="width: 80px; height: 80px;">
                            <span class="position-absolute bottom-0 end-0 bg-warning rounded-circle p-1" style="width: 20px; height: 20px;">
                                <span class="visually-hidden">Busy</span>
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Dr. Siti Nurhaliza, S.Kom., M.T</h5>
                        <p class="text-muted small mb-0">NIP. 197803152005012001</p>
                    </div>
                    
                    <div class="mb-3">
                        <div class="row text-center g-2">
                            <div class="col-4">
                                <div class="bg-light rounded-3 p-2">
                                    <i class="fas fa-graduation-cap text-primary mb-1 d-block"></i>
                                    <small class="text-muted">TKJ</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-light rounded-3 p-2">
                                    <i class="fas fa-users text-warning mb-1 d-block"></i>
                                    <small class="text-muted">12/15</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-light rounded-3 p-2">
                                    <i class="fas fa-star text-warning mb-1 d-block"></i>
                                    <small class="text-muted">4.9</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-semibold text-secondary mb-2">
                            <i class="fas fa-cogs me-2"></i>Keahlian:
                        </h6>
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge bg-danger-subtle text-danger rounded-pill">Network Security</span>
                            <span class="badge bg-warning-subtle text-warning rounded-pill">System Admin</span>
                            <span class="badge bg-primary-subtle text-primary rounded-pill">IoT</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" style="border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#detailModal">
                            <i class="fas fa-eye me-2"></i>Lihat Detail
                        </button>
                        <button class="btn btn-primary" style="border-radius: 10px; background: linear-gradient(45deg, #667eea, #764ba2);">
                            <i class="fas fa-user-plus me-2"></i>Pilih Pembimbing
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pembimbing Card 3 -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)'">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <div class="position-relative d-inline-block">
                            <img src="https://ui-avatars.com/api/?name=Muhammad+Rizki&background=28a745&color=fff&size=80&rounded=true" alt="Profile" class="rounded-circle mb-2" style="width: 80px; height: 80px;">
                            <span class="position-absolute bottom-0 end-0 bg-danger rounded-circle p-1" style="width: 20px; height: 20px;">
                                <span class="visually-hidden">Full</span>
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Muhammad Rizki, S.Sn., M.Ds</h5>
                        <p class="text-muted small mb-0">NIP. 198909152015031002</p>
                    </div>
                    
                    <div class="mb-3">
                        <div class="row text-center g-2">
                            <div class="col-4">
                                <div class="bg-light rounded-3 p-2">
                                    <i class="fas fa-graduation-cap text-primary mb-1 d-block"></i>
                                    <small class="text-muted">MM</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-light rounded-3 p-2">
                                    <i class="fas fa-users text-danger mb-1 d-block"></i>
                                    <small class="text-muted">15/15</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-light rounded-3 p-2">
                                    <i class="fas fa-star text-warning mb-1 d-block"></i>
                                    <small class="text-muted">4.7</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-semibold text-secondary mb-2">
                            <i class="fas fa-cogs me-2"></i>Keahlian:
                        </h6>
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge bg-purple-subtle text-purple rounded-pill">UI/UX Design</span>
                            <span class="badge bg-info-subtle text-info rounded-pill">Graphic Design</span>
                            <span class="badge bg-success-subtle text-success rounded-pill">Video Editing</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" style="border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#detailModal">
                            <i class="fas fa-eye me-2"></i>Lihat Detail
                        </button>
                        <button class="btn btn-secondary" style="border-radius: 10px;" disabled>
                            <i class="fas fa-user-times me-2"></i>Kuota Penuh
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

                        <div class="mb-4">
                            <h6 class="fw-bold text-secondary mb-2">
                                <i class="fas fa-trophy me-2"></i>Prestasi & Sertifikasi
                            </h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-medal text-warning me-2"></i>
                                    Guru Berprestasi Tingkat Nasional 2023
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-certificate text-primary me-2"></i>
                                    Certified Web Developer Professional
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-award text-success me-2"></i>
                                    Pembimbing Terbaik Lomba Kompetensi Siswa 2022
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
                <button type="button" class="btn btn-primary" style="border-radius: 10px; background: linear-gradient(45deg, #667eea, #764ba2);">
                    <i class="fas fa-user-plus me-2"></i>Pilih sebagai Pembimbing
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