@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="card mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Pengajuan PKL</h5>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    {{-- Jika tidak ada pengajuan untuk IDUKA --}}
                    @if($pengajuanUsulans->isEmpty())
                    <p class="text-center">Tidak ada pengajuan yang tersedia untuk IDUKA ini.</p>
                    @else
                    {{-- Looping Daftar Siswa --}}
                    @foreach($pengajuanUsulans as $pengajuan)
                    <div class="card mb-3 shadow-sm" style="padding: 20px; border-radius: 10px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="mb-0" style="font-size: 18px">
                                    <strong>{{ $pengajuan->dataPribadi->name ?? 'Nama Tidak Tersedia' }}</strong>
                                </div>
                                <div>
                                    Kelas: {{ $pengajuan->dataPribadi->kelas->kelas ?? '-' }} {{ $pengajuan->dataPribadi->kelas->name_kelas ?? '-' }}
                                </div>

                                <div>
                                    Status: {{ ucfirst($pengajuan->status) }}
                                </div>
                            </div>

                            <div>
                                @if($pengajuan->status !== 'proses')
                                <span class="badge bg-success">{{ ucfirst($pengajuan->status) }}</span>
                                @else
                                <button class="btn btn-success btn-update-status" data-id="{{ $pengajuan->id }}" data-status="diterima">Terima</button>
                                <button class="btn btn-danger btn-update-status" data-id="{{ $pengajuan->id }}" data-status="ditolak">Tolak</button>
                                @endif

                            </div>

                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.btn-update-status');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const status = this.dataset.status;

                if (confirm(`Yakin ingin ${status} pengajuan ini?`)) {
                    axios.put(`/kaprog/review/usulan-pkl/status/${id}`, {
                        status: status
                    })
                    .then(response => {
                        // Reload halaman atau tampilkan notifikasi
                        location.reload();
                    })
                    .catch(error => {
                        alert('Terjadi kesalahan saat memperbarui status.');
                    });
                }
            });
        });
    });
</script>
@endpush
