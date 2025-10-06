@extends('layout.main')
@section('content')
    <div class="container-fluid mt-4">
        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Card Header -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0 text-primary">Daftar IDUKA</h3>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <!-- Search Box -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form action="{{ route('hubin.iduka.daftar') }}" method="GET">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 ps-0"
                                        placeholder="Cari nama, NIP, atau email..." name="search"
                                        value="{{ $search ?? '' }}">
                                    <button class="btn btn-primary" type="submit">
                                        Cari
                                    </button>
                                    @if ($search ?? false)
                                        <a href="{{ route('hubin.iduka.daftar') }}" class="btn btn-outline-secondary">
                                            Reset
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-md-end mt-2 mt-md-0">
                            <span class="text-muted">Menampilkan {{ $data->count() }} dari {{ $data->total() }} data</span>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" width="5%">No</th>
                                    <th scope="col" width="30%">Nama</th>
                                    <th scope="col" width="15%">Latitude</th>
                                    <th scope="col" width="15%">Longitude</th>
                                    <th scope="col" width="10%">Radius (m)</th>
                                    <th scope="col" width="10%">Jam Masuk Iduka</th>
                                    <th scope="col" width="10%">Jam Pulang Iduka</th>
                                    <th scope="col" width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $iduka)
                                    <tr>
                                        <td>{{ $data->firstItem() + $loop->index }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <div class="avatar-title rounded-circle bg-primary text-white">
                                                        {{ strtoupper(substr($iduka->nama, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $iduka->nama }}</div>
                                                    <div class="small text-muted">{{ $iduka->email ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-monospace">{{ $iduka->latitude ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="text-monospace">{{ $iduka->longitude ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $iduka->radius ?? 0 }} m</span>
                                        </td>
                                        <td>{{ $iduka->jam_masuk ? \Carbon\Carbon::parse($iduka->jam_masuk)->format('H:i') : '08:00' }}
                                            WIB</td>
                                        <td>{{ $iduka->jam_pulang ? \Carbon\Carbon::parse($iduka->jam_pulang)->format('H:i') : '15:00' }}
                                            WIB</td>



                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-warning btn-edit"
                                                    data-id="{{ $iduka->id }}" data-nama="{{ $iduka->nama }}"
                                                    data-email="{{ $iduka->email }}"
                                                    data-latitude="{{ $iduka->latitude ?? '' }}"
                                                    data-longitude="{{ $iduka->longitude ?? '' }}"
                                                    data-radius="{{ $iduka->radius ?? '' }}"
                                                    data-jam_masuk="{{ $iduka->jam_masuk ?? '08:00' }}"
                                                    data-jam_pulang="{{ $iduka->jam_pulang ?? '15:00' }}" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox display-4 d-block"></i>
                                                <span>Tidak ada data IDUKA</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="row align-items-center mt-4">
                        <div class="d-flex justify-content-end mt-3">
                            {{ $data->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data IDUKA</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editForm">
                        <div class="modal-body">
                            <input type="hidden" id="editId" name="id">

                            <div class="mb-3">
                                <label for="editNama" class="form-label">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editNama" name="nama" required>
                            </div>

                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="email">
                            </div>

                            <div class="mb-3">
                                <label for="editLatitude" class="form-label">Latitude</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <input type="number" class="form-control" id="editLatitude" name="latitude"
                                        step="any" placeholder="-6.2088">
                                </div>
                                <small class="form-text text-muted">Contoh: -6.2088</small>
                            </div>

                            <div class="mb-3">
                                <label for="editLongitude" class="form-label">Longitude</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <input type="number" class="form-control" id="editLongitude" name="longitude"
                                        step="any" placeholder="106.8456">
                                </div>
                                <small class="form-text text-muted">Contoh: 106.8456</small>
                            </div>

                            <div class="mb-3">
                                <label for="editRadius" class="form-label">Radius (meter)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-rulers"></i></span>
                                    <input type="number" class="form-control" id="editRadius" name="radius"
                                        placeholder="100">
                                </div>
                                <small class="form-text text-muted">Jari-jari area dalam meter</small>
                            </div>

                            <div class="mb-3">
                                <label for="jam_masuk" class="form-label">Jam
                                    Masuk</label>
                                <input type="time" class="form-control" id="jam_masuk" name="jam_masuk">
                                <div class="form-text">Default: 08:00</div>
                            </div>

                            <div class="mb-3">
                                <label for="jam_pulang" class="form-label">Jam Pulang</label>
                                <input type="time" class="form-control" id="jam_pulang" name="jam_pulang">
                                <div class="form-text">Default: 15:00</div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .avatar {
            position: relative;
            display: inline-block;
        }

        .avatar-title {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            font-weight: 500;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }

        .btn-group-sm>.btn,
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .table thead th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-bottom: 2px solid #dee2e6;
        }

        .table td,
        .table th {
            padding: 1rem;
            vertical-align: middle;
        }

        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }

        .text-monospace {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 0.9rem;
        }

        /* Custom Pagination Styling */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            color: #0d6efd;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        /* Modal Styling */
        .modal-content {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .input-group-text {
            background-color: #f8f9fa;
        }

        .form-label {
            font-weight: 500;
        }
    </style>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle edit button click
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function() {
                    // Get data attributes
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');
                    const email = this.getAttribute('data-email');
                    const latitude = this.getAttribute('data-latitude');
                    const longitude = this.getAttribute('data-longitude');
                    const radius = this.getAttribute('data-radius');
                    const jam_masuk = this.getAttribute('data-jam_masuk');
                    const jam_pulang = this.getAttribute('data-jam_pulang');

                    // Fill form fields
                    document.getElementById('editId').value = id;
                    document.getElementById('editNama').value = nama;
                    document.getElementById('editEmail').value = email;
                    document.getElementById('editLatitude').value = latitude;
                    document.getElementById('editLongitude').value = longitude;
                    document.getElementById('editRadius').value = radius;
                    document.getElementById('jam_masuk').value = jam_masuk;
                    document.getElementById('jam_pulang').value = jam_pulang;

                    // Show modal
                    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                    editModal.show();
                });
            });

            // Handle form submission
            document.getElementById('editForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const id = formData.get('id');

                fetch(`/hubin/iduka/${id}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            nama: formData.get('nama'),
                            email: formData.get('email'),
                            latitude: formData.get('latitude'),
                            longitude: formData.get('longitude'),
                            radius: formData.get('radius'), // ✅ koma sudah benar di sini
                            jam_masuk: formData.get('jam_masuk'),
                            jam_pulang: formData.get('jam_pulang'),
                        })
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Terjadi kesalahan saat memperbarui data');
                        return response.json();
                    })
                    .then(data => {
                        const editModal = bootstrap.Modal.getInstance(document.getElementById(
                            'editModal'));
                        editModal.hide();
                        alert('Data berhasil diperbarui!');
                        setTimeout(() => window.location.reload(), 1000);
                    })
                    .catch(error => {
                        alert('Gagal memperbarui data: ' + error.message);
                    });
            });
        });
    </script>
@endsection
