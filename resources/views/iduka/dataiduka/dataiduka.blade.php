@extends('layout.main')

@section('content')
<style>
     .card-hover {
            transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
            position: relative;
            /* Pastikan elemen ini menjadi referensi posisi */
        }

        .card-hover:hover {
            transform: scale(1.03);
            background-color: #7e7dfb !important;
            color: white !important;
            z-index: 1;
            /* Pastikan card tetap di bawah dropdown */
        }

        .card-hover:hover .btn-hover {
            background-color: white;
            color: #7e7dfb;
            border-color: white;
        }

        .btn-hover {
            background-color: #7e7dfb;
            color: white;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            border-radius: 50px;
            border: 2px solid #7e7dfb;
        }

        .btn-hover:hover {
            background-color: white;
            color: #7e7dfb;
            border-color: white;
        }

        .dropdown-btn {
            color: #7e7dfb;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            border-radius: 50px;
            padding: 5px 12px;
            font-size: 25px;
        }

        .card-hover:hover .dropdown-btn {
            color: white !important;
        }

        .dropdown-menu {
            z-index: 9999 !important;
            /* Pastikan dropdown selalu di atas */
            position: absolute !important;
            /* Jangan biarkan Bootstrap mengubahnya */
            transform: translate3d(0px, 0px, 0px) !important;
            will-change: transform;
        }

</style>
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                {{-- Card Header --}}
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">Data Institusi / Perusahaan</h5>

                            <div class="d-none d-md-flex gap-2 align-items-center">
                                <select class="form-select form-select-sm w-auto" id="filterIduka">
                                    <option value="all">Semua</option>
                                    <option value="rekomendasi">Rekomendasi</option>
                                    <option value="ajuan">Ajuan</option>
                                </select>

                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#searchModal">
                                    <i class="bi bi-search"></i>
                                </button>

                                @if (in_array(auth()->user()->role, ['hubin', 'kaprog']))
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#tambahIdukaModal">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                @endif
                            </div>

                            {{-- Mobile Dropdown --}}
                            <div class="d-flex d-md-none justify-content-end">
                                <div class="dropdown">
                                    <button class="btn" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        ⋮
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="{{ route('siswa.dashboard') }}" class="dropdown-item text-primary">
                                                <i class="bi bi-arrow-left-circle me-2"></i> Kembali
                                            </a>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item text-warning"
                                                data-bs-toggle="modal" data-bs-target="#searchModal">
                                                <i class="bi bi-search me-2"></i> Cari
                                            </button>
                                        </li>
                                        @if (in_array(auth()->user()->role, ['hubin', 'kaprog']))
                                            <li>
                                                <button type="button" class="dropdown-item text-primary"
                                                    data-bs-toggle="modal" data-bs-target="#tambahIdukaModal">
                                                    <i class="bi bi-plus-lg me-2"></i> Tambah Institusi
                                                </button>
                                            </li>
                                        @endif
                                        <li>
                                            <div class="px-3 pt-2">
                                                <select class="form-select form-select-sm" id="filterIdukaMobile">
                                                    <option value="all">Semua</option>
                                                    <option value="rekomendasi">Rekomendasi</option>
                                                    <option value="ajuan">Ajuan</option>
                                                </select>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- Modal Search --}}
                    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="searchModalLabel">Cari Institusi / Perusahaan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" id="searchInput" name="search" class="form-control"
                                        placeholder="Cari Institusi / Perusahaan...">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary btn-sm" id="searchButton">Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3" id="idukaContainer">
                        @if ($iduka->isEmpty())
                            <div class="alert alert-warning">
                                Belum ada data institusi / perusahaan yang tersedia.
                            </div>
                        @else
                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @foreach ($iduka as $i)
                                <div class="card mb-3 shadow-sm card-hover p-3" style="border-radius: 10px;"
                                    data-rekomendasi="{{ $i->rekomendasi ? 'rekomendasi' : 'ajuan' }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div style="min-width: 0;">
                                            <!-- Nama Iduka dengan batas 2 baris -->
                                            <div class="fw-bold text-truncate d-inline-block w-100"
                                                style="font-size: 16px; max-height: 40px; overflow: hidden;">
                                                {{ $i->nama }}
                                            </div>
                                            <!-- Alamat dengan text-truncate -->
                                            <div class="text-muted text-truncate w-100" style="font-size: 14px;">
                                                {{ $i->alamat }}
                                            </div>
                                            @if ($i->rekomendasi == 1)
                                                <div class="text-success mt-1" style="font-size: 13px;">
                                                    <strong>Rekomendasi:</strong> INSTITUSI ini direkomendasikan
                                                </div>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center">
                                            @if (auth()->user()->role == 'kaprog')
                                                <a href="{{ route('detail.iduka', $i->id) }}"
                                                    class="btn btn-hover rounded-pill btn-sm">Detail</a>
                                            @elseif(auth()->user()->role == 'hubin')
                                                <a href="{{ route('hubin.detail.iduka', $i->id) }}"
                                                    class="btn btn-hover rounded-pill btn-sm">Detail</a>
                                            @endif

                                            @if (auth()->user()->role === 'kaprog')
                                                <button type="button" class="btn btn-hover rounded-pill btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#aturTanggalModalKaprog{{ $i->id }}">
                                                    <i class="bi bi-calendar-event"></i>
                                                </button>
                                            @elseif(auth()->user()->role === 'hubin')
                                                <button type="button" class="btn btn-outline-primary btn-sm ms-2"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#aturTanggalModalHubin{{ $i->id }}">
                                                    <i class="bi bi-calendar-event"></i>
                                                </button>
                                            @endif

                                            <div class="dropdown ms-2">
                                                
                                                <button class="btn dropdown-btn" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">⋮</button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <form action="{{ route('iduka.destroy', $i->id) }}" method="POST"
                                                            class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">Hapus</button>
                                                        </form>
                                                    </li>
                                                    <!-- Tombol Edit -->
                                                    <li>
                                                       
                                                    </li>  <li>
                                                        <button class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#editKelasModal{{ $i->id }}">
                                                            Edit
                                                        </button>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (auth()->user()->role === 'kaprog')
                                    <!-- Modal Atur Tanggal Kaprog -->
                                    <div class="modal fade" id="aturTanggalModalKaprog{{ $i->id }}"
                                        tabindex="-1" aria-labelledby="aturTanggalLabelKaprog{{ $i->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('kaprog.tanggal.update', $i->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="aturTanggalLabelKaprog{{ $i->id }}">Atur Batas
                                                            Waktu Usulan (Kaprog)</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="tanggal_awalKaprog{{ $i->id }}"
                                                                class="form-label">Tanggal Awal</label>
                                                            <input type="date" class="form-control"
                                                                id="tanggal_awalKaprog{{ $i->id }}"
                                                                name="tanggal_awal" value="{{ $i->tanggal_awal }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tanggal_akhirKaprog{{ $i->id }}"
                                                                class="form-label">Tanggal Akhir</label>
                                                            <input type="date" class="form-control"
                                                                id="tanggal_akhirKaprog{{ $i->id }}"
                                                                name="tanggal_akhir" value="{{ $i->tanggal_akhir }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @elseif(auth()->user()->role === 'hubin')
                                    <!-- Modal Atur Tanggal Hubin -->
                                    <div class="modal fade" id="aturTanggalModalHubin{{ $i->id }}" tabindex="-1"
                                        aria-labelledby="aturTanggalLabelHubin{{ $i->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('hubin.tanggal.update', $i->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="aturTanggalLabelHubin{{ $i->id }}">Atur Batas Waktu
                                                            Usulan (Hubin)</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="tanggal_awalHubin{{ $i->id }}"
                                                                class="form-label">Tanggal Awal</label>
                                                            <input type="date" class="form-control"
                                                                id="tanggal_awalHubin{{ $i->id }}"
                                                                name="tanggal_awal" value="{{ $i->tanggal_awal }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tanggal_akhirHubin{{ $i->id }}"
                                                                class="form-label">Tanggal Akhir</label>
                                                            <input type="date" class="form-control"
                                                                id="tanggal_akhirHubin{{ $i->id }}"
                                                                name="tanggal_akhir" value="{{ $i->tanggal_akhir }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="card">
                        <div class="d-flex justify-content-end mt-3">
                            {{ $iduka->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- Modal Edit Iduka --}}
@foreach ($iduka as $i)
<div class="modal fade" id="editKelasModal{{ $i->id }}" tabindex="-1" aria-labelledby="editKelasModalLabel{{ $i->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editKelasModalLabel{{ $i->id }}">Edit Data {{ $i->nama }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('updateiduka.update', parameters: $i->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">

                            <div class="mb-3">
                                <label for="nama{{ $i->id }}" class="form-label">Nama Institusi*</label>
                                <input type="text" class="form-control" id="nama{{ $i->id }}" name="nama" value="{{ $i->nama }}" required>
                                <small class="form-text text-muted">Nama Institusi ini akan tercatat di sistem, pastikan sudah benar ya!</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nama_pimpinan{{ $i->id }}" class="form-label">Nama Pimpinan*</label>
                                <input type="text" class="form-control" id="nama_pimpinan{{ $i->id }}" name="nama_pimpinan" value="{{ $i->nama_pimpinan }}" required>
                                <small class="form-text text-muted">Nama lengkap ini akan tercatat di sistem, pastikan sudah benar ya!</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nip_pimpinan{{ $i->id }}" class="form-label">NIP Pimpinan*</label>
                                <input type="text" class="form-control" id="nip_pimpinan{{ $i->id }}" name="nip_pimpinan" value="{{ $i->nip_pimpinan }}" required>
                                <small class="form-text text-muted">Isi NIP atau NUPTK di sini, pastikan sudah benar ya!</small></div>
                            
                            <div class="mb-3">
                                <label for="no_hp_pimpinan{{ $i->id }}" class="form-label">No HP Pimpinan*</label>
                                <input type="text" class="form-control" id="no_hp_pimpinan{{ $i->id }}" name="no_hp_pimpinan" value="{{ $i->no_hp_pimpinan }}" required>
                                <small class="form-text text-muted">Masukkan nomor telepon aktif. Pastikan bisa diakses ya!</small></div>
                            
                            <div class="mb-3">
                                <label for="jabatan{{ $i->id }}" class="form-label">Jabatan*</label>
                                <input type="text" class="form-control" id="jabatan{{ $i->id }}" name="jabatan" value="{{ $i->jabatan }}" required>
                            </div>
                       
                        
                        <!-- Kolom Kanan -->
                      
                            <div class="mb-3">
                                <label for="alamat{{ $i->id }}" class="form-label">Alamat*</label>
                                <textarea class="form-control" id="alamat{{ $i->id }}" name="alamat" required>{{ $i->alamat }}</textarea>
                                <small class="form-text text-muted">Masukkan alamat lengkap lokasi PKL di sini ya.</small></div>
                            
                            <div class="mb-3">
                                <label for="kode_pos{{ $i->id }}" class="form-label">Kode Pos*</label>
                                <input type="text" class="form-control" id="kode_pos{{ $i->id }}" name="kode_pos" value="{{ $i->kode_pos }}" required>
                                <small class="form-text text-muted">Masukkan nomor telepon aktif. Pastikan bisa diakses ya!</small></div>
                            
                            <div class="mb-3">
                                <label for="telepon{{ $i->id }}" class="form-label">Telepon*</label>
                                <input type="text" class="form-control" id="telepon{{ $i->id }}" name="telepon" value="{{ $i->telepon }}" required>
                                <small class="form-text text-muted">Masukkan nomor telepon aktif. Pastikan bisa diakses ya!</small> </div>
                            
                            <div class="mb-3">
                                <label for="email{{ $i->id }}" class="form-label">Email*</label>
                                <input type="email" class="form-control" id="email{{ $i->id }}" name="email" value="{{ $i->email }}" required>
                                <small class="form-text text-muted">Masukkan email aktif. Pastikan bisa diakses ya!</small></div>
                            
                            <div class="mb-3">
                                <label for="password{{ $i->id }}" class="form-label">Password (Biarkan kosong jika tidak ingin diubah)</label>
                                <input type="password" class="form-control" id="password{{ $i->id }}" name="password" placeholder="Kosongkan jika tidak diubah">
                        <small class="form-text text-muted">Password minimal 8 karakter.</small>
                    </div>
                       
                    
                    <!-- Bagian Bawah -->
                 
                            <div class="mb-3">
                                <label for="bidang_industri{{ $i->id }}" class="form-label">Bidang Industri*</label>
                                <input type="text" class="form-control" id="bidang_industri{{ $i->id }}" name="bidang_industri" value="{{ $i->bidang_industri }}" required>
                                <small class="form-text text-muted">Silakan isi bidang industri yang Anda tekuni secara spesifik dan sesuai dengan sektor usaha.</small></div>
                            
                            <div class="mb-3">
                                <label class="form-label">Kerjasama*</label>
                                <select class="form-select" name="kerjasama" id="kerjasama{{ $i->id }}" required>
                                    <option value="">Pilih Jenis Kerjasama</option>
                                    <option value="Sinkronisasi" {{ $i->kerjasama == 'Sinkronisasi' ? 'selected' : '' }}>Sinkronisasi</option>
                                    <option value="Guru Tamu" {{ $i->kerjasama == 'Guru Tamu' ? 'selected' : '' }}>Guru Tamu</option>
                                    <option value="Magang / Pelatihan" {{ $i->kerjasama == 'Magang / Pelatihan' ? 'selected' : '' }}>Magang / Pelatihan</option>
                                    <option value="PKL" {{ $i->kerjasama == 'PKL' ? 'selected' : '' }}>PKL</option>
                                    <option value="Sertifikasi" {{ $i->kerjasama == 'Sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
                                    <option value="Tefa" {{ $i->kerjasama == 'Tefa' ? 'selected' : '' }}>Tefa</option>
                                    <option value="Serapan" {{ $i->kerjasama == 'Serapan' ? 'selected' : '' }}>Serapan</option>
                                    <option value="Beasiswa" {{ $i->kerjasama == 'Beasiswa' ? 'selected' : '' }}>Beasiswa</option>
                                    <option value="PBL" {{ $i->kerjasama == 'PBL' ? 'selected' : '' }}>PBL</option>
                                    <option value="Lainnya" {{ $i->kerjasama == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            
                            <div class="mb-3" id="kerjasama_lainnya_container{{ $i->id }}" style="{{ $i->kerjasama == 'Lainnya' ? '' : 'display:none;' }}">
                                <label for="kerjasama_lainnya{{ $i->id }}" class="form-label">Jenis Kerjasama Lainnya</label>
                                <input type="text" class="form-control" id="kerjasama_lainnya{{ $i->id }}" name="kerjasama_lainnya" value="{{ $i->kerjasama_lainnya }}">
                            </div>
                    
                        
                      
                            <div class="mb-3">
                                <label for="kuota_pkl{{ $i->id }}" class="form-label">Kuota PKL*</label>
                                <input type="number" class="form-control" id="kuota_pkl{{ $i->id }}" name="kuota_pkl" value="{{ $i->kuota_pkl }}" required>
                                <small class="form-text text-muted">Masukkan jumlah kuota PKL yang tersedia untuk siswa.</small>  </div>
                            
                            @if(auth()->user()->role == 'hubin')
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="rekomendasi{{ $i->id }}" name="rekomendasi" value="1" {{ $i->rekomendasi ? 'checked' : '' }}>
                                <label class="form-check-label" for="rekomendasi{{ $i->id }}">Rekomendasi</label>
                            </div>
                            @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endforeach
    {{-- Include Modal Tambah Iduka --}}
    @include('iduka.dataiduka.createiduka')



    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Script --}}
    <script>
        <script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle kerjasama lainnya
    @foreach($iduka as $i)
    document.getElementById('kerjasama{{ $i->id }}').addEventListener('change', function() {
        const container = document.getElementById('kerjasama_lainnya_container{{ $i->id }}');
        if (this.value === 'Lainnya') {
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    });
    @endforeach

    // Validasi form
    @foreach($iduka as $i)
    document.querySelector('form[action="{{ route('iduka.update', $i->id) }}"]').addEventListener('submit', function(e) {
        const kerjasama = document.getElementById('kerjasama{{ $i->id }}').value;
        const lainnya = document.getElementById('kerjasama_lainnya{{ $i->id }}').value;
        
        if (kerjasama === 'Lainnya' && !lainnya) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Harap isi jenis kerjasama lainnya!'
            });
        }
    });
    @endforeach
});
</script>



           document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".dropdown-btn").forEach(function(btn) {
                    btn.addEventListener("click", function() {
                        let dropdownMenu = this.nextElementSibling;

                        // Hapus semua dropdown yang sudah aktif
                        document.querySelectorAll(".dropdown-menu").forEach(menu => {
                            if (menu !== dropdownMenu) {
                                menu.style.zIndex =
                                "9999"; // Pastikan semua dropdown tetap di atas
                            }
                        });

                        // Pastikan dropdown saat ini di atas semua elemen
                        dropdownMenu.style.zIndex = "10000";
                    });
                });

                // Tutup dropdown saat klik di luar
                document.addEventListener("click", function(event) {
                    if (!event.target.matches(".dropdown-btn")) {
                        document.querySelectorAll(".dropdown-menu").forEach(menu => {
                            menu.style.zIndex = "9999";
                        });
                    }
                });
            });
        document.addEventListener('DOMContentLoaded', function() {
            // Konfirmasi Hapus
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Apakah kamu yakin?",
                        text: "Data ini tidak bisa dikembalikan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest('form').submit();
                        }
                    });
                });
            });

            // SweetAlert Sukses
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif

            // Filter + Search
            const filterSelect = document.getElementById('filterIduka');
            const filterSelectMobile = document.getElementById('filterIdukaMobile');
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchButton');
            const idukaCards = document.querySelectorAll('#idukaContainer .card-hover');

            function filterIduka() {
                const filter = filterSelect.value;
                const search = searchInput.value.toLowerCase();

                idukaCards.forEach(card => {
                    const rekomendasi = card.getAttribute('data-rekomendasi');
                    const nama = card.querySelector('.fw-bold').textContent.toLowerCase();
                    const alamat = card.querySelector('.text-muted').textContent.toLowerCase();

                    const matchFilter = filter === 'all' || rekomendasi === filter;
                    const matchSearch = search === '' || nama.includes(search) || alamat.includes(search);

                    card.style.display = (matchFilter && matchSearch) ? 'block' : 'none';
                });
            }

            filterSelect.addEventListener('change', filterIduka);
            filterSelectMobile.addEventListener('change', function() {
                filterSelect.value = this.value;
                filterIduka();
            });
            searchButton.addEventListener('click', filterIduka);
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    filterIduka();
                }
            });
        });

     

    </script>

    {{-- CSS tambahan --}}
    <style>
        .card-hover {
            transition: transform 0.3s ease, background-color 0.3s ease, color 0.3s ease;
        }

        .card-hover:hover {
            transform: scale(1.03);
            background-color: #7e7dfb !important;
            color: white !important;
        }

        .card-hover:hover .btn-hover {
            background-color: white;
            color: #7e7dfb;
        }

        .btn-hover {
            background-color: #7e7dfb;
            color: white;
            border-radius: 50px;
            transition: all 0.3s;
        }

        .dropdown-btn {
            color: #7e7dfb;
            font-size: 24px;
        }

        .card-hover:hover .dropdown-btn {
            color: white;
        }
    </style>
@endsection
