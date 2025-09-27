@extends('layout.main')

@section('content')
    <div class="container">
        <h5 class="fw-bold mt-5">
            <i class="bx bx-desktop text-primary"></i>
            Monitoring IDUKA
        </h5>

        {{-- Alert Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bx bx-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Kartu Statistik --}}
        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm h-100">
                    <div class="card-body">
                        <i class="bx bx-desktop text-primary fs-2 mb-2"></i>
                        <h6 class="text-muted">Total Monitoring</h6>
                        <h3 class="fw-bold text-primary">{{ $totalMonitoring }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm h-100">
                    <div class="card-body">
                        <i class="bx bx-buildings text-info fs-2 mb-2"></i>
                        <h6 class="text-muted">Total IDUKA</h6>
                        <h3 class="fw-bold text-info">{{ $totalIduka }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm h-100">
                    <div class="card-body">
                        <i class="bx bx-check-circle text-success fs-2 mb-2"></i>
                        <h6 class="text-muted">IDUKA Termonitor</h6>
                        <h3 class="fw-bold text-success">{{ $totalIdukaWithMonitoring }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm h-100">
                    <div class="card-body">
                        <i class="bx bx-x-circle text-warning fs-2 mb-2"></i>
                        <h6 class="text-muted">Belum Termonitor</h6>
                        <h3 class="fw-bold text-warning">{{ $totalIdukaWithoutMonitoring }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <div class="card text-center border-0 shadow-sm h-100">
                    <div class="card-body">
                        <i class="bx bx-user-check text-success fs-2 mb-2"></i>
                        <h6 class="text-muted">Perkiraan Siswa Diterima</h6>
                        <h3 class="fw-bold text-success">{{ $totalPerkiraanSiswa }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter dan Tambah Data --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <form method="GET" action="{{ route('monitoring.index') }}">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-6">
                                    <input type="text" name="nama_iduka" value="{{ request('nama_iduka') }}" 
                                           class="form-control" placeholder="Cari IDUKA...">
                                </div>
                                <div class="col-md-6 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i> Cari
                                    </button>
                                    <a href="{{ route('monitoring.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-sync-alt me-2"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{-- Tombol Tambah hanya untuk selain kaprog --}}
            <div class="col-md-4 text-md-end">
                @if (auth()->user()->role !== 'kaprog')
                    <a href="{{ route('monitoring.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i> Tambah Monitoring
                    </a>
                @endif
            </div>
                </div>
            </div>
        </div>

        {{-- Tabel Monitoring --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0">
                <h5 class="card-title fw-bold mb-0">
                    <i class="bx bx-list-ul text-primary me-2"></i>
                    Data Monitoring
                </h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 fw-semibold text-muted small px-4 py-3">NO</th>
                                <th class="border-0 fw-semibold text-muted small py-3">NAMA IDUKA</th>
                                <th class="border-0 fw-semibold text-muted small py-3">SARAN / CATATAN</th>
                                <th class="border-0 fw-semibold text-muted small py-3">PERKIRAAN SISWA DITERIMA</th>
                                <th class="border-0 fw-semibold text-muted small py-3">FOTO</th>
                                <th class="border-0 fw-semibold text-muted small py-3">TANGGAL UPDATE</th>
                                <th class="border-0 fw-semibold text-muted small py-3 text-center">AKSI</th>
                            </tr>
                        </thead>
                       <tbody>
    @forelse ($monitoring as $index => $item)
        <tr>
            <td class="px-4">{{ $monitoring->firstItem() + $index }}</td>
            <td>
                <div class="fw-semibold">{{ $item->iduka->nama ?? '-' }}</div>
                <small class="text-muted">{{ $item->iduka->alamat ?? '-' }}</small>
            </td>
            <td>
                <div style="max-width: 250px;">
                    {{ Str::limit($item->saran, 100) ?: '-' }}
                </div>
            </td>
            <td class="text-center">
                <span class="badge bg-info fs-6">
                    {{ $item->perkiraan_siswa_diterima ?? 0 }} siswa
                </span>
            </td>
            <td class="text-center">
                @if ($item->foto)
                    <button class="btn btn-outline-primary btn-sm" 
                            onclick="showImage('{{ Storage::url('monitoring/' . $item->foto) }}', '{{ $item->iduka->nama }}')">
                        <i class="fas fa-image"></i> Lihat
                    </button>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>
                <small class="text-muted">
                    {{ $item->updated_at->format('d/m/Y H:i') }}
                </small>
            </td>

            {{-- Tombol Aksi --}}
            <td class="text-center">
                <div class="btn-group" role="group">
                    {{-- Tombol lihat selalu tampil --}}
                    <a href="{{ route('monitoring.show', $item->id) }}" 
                       class="btn btn-outline-info btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>

                    {{-- Tombol edit & hapus hanya tampil jika bukan kaprog --}}
                    @if (auth()->user()->role !== 'kaprog')
                        <a href="{{ route('monitoring.edit', $item->id) }}" 
                           class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-outline-danger btn-sm" 
                                onclick="confirmDelete({{ $item->id }}, '{{ $item->iduka->nama }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    @endif
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center py-4">
                <div class="text-muted">
                    <i class="bx bx-folder-open fs-1"></i>
                    <div class="mt-2">Belum ada data monitoring</div>
                </div>
            </td>
        </tr>
    @endforelse
</tbody>

                    </table>
                </div>
            </div>

            @if($monitoring->hasPages())
                <div class="card-footer bg-transparent border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Menampilkan {{ $monitoring->firstItem() }} - {{ $monitoring->lastItem() }} 
                            dari {{ $monitoring->total() }} data
                        </small>
                        <nav>
                            {{ $monitoring->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal untuk menampilkan gambar --}}
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Foto Monitoring</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    {{-- Modal konfirmasi hapus --}}
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data monitoring untuk <strong id="deleteItemName"></strong>?</p>
                    <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showImage(imageUrl, title) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('imageModalLabel').textContent = 'Foto Monitoring - ' + title;
            new bootstrap.Modal(document.getElementById('imageModal')).show();
        }

        function confirmDelete(id, name) {
            document.getElementById('deleteItemName').textContent = name;
            document.getElementById('deleteForm').action = '/monitoring/' + id;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>
@endpush