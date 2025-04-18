@extends('layout.main')

@section('content')
    <div class="container-fluid">
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="card mb-3">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Detail Pengajuan PKL ke: {{ $iduka->nama }}</h5>
                            <a href="{{ route('kaprog.review.pengajuan') }}" class="btn btn-secondary btn-sm">← Kembali</a>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        @if ($pengajuans->isEmpty())
                            <p class="text-center">Tidak ada pengajuan yang tersedia untuk IDUKA ini.</p>
                        @else
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('info'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    {{ session('info') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @foreach ($pengajuans as $pengajuan)
                                <div class="card mb-3 shadow-sm" style="padding: 20px; border-radius: 10px;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="mb-0" style="font-size: 18px">
                                                <strong>{{ $pengajuan->dataPribadi->name ?? 'Nama Tidak Tersedia' }}</strong>
                                            </div>
                                            <div>
                                                Kelas: {{ $pengajuan->dataPribadi->kelas->kelas ?? '-' }}
                                                {{ $pengajuan->dataPribadi->kelas->name_kelas ?? '-' }}
                                            </div>
                                            <div>
                                                Status: {{ ucfirst($pengajuan->status) }}
                                            </div>
                                        </div>
                                        <div>
                                            {{-- Tombol untuk melihat detail --}}
                                            <a href="{{ route('persuratan.suratPengajuan.detailSuratPengajuan', $pengajuan->id) }}"
                                                class="btn btn-info">
                                                Lihat Detail
                                            </a>
                                            @if ($pengajuan->status === 'diterima') 
                                                <button class="btn btn-success" disabled>Sudah Dikirim</button>
                                            @else
                                                <form
                                                    action="{{ route('kaprog.pengajuan.prosesPengajuan', $pengajuan->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    <input type="hidden" name="iduka_id" value="{{ $iduka->id }}">
                                                    <button type="submit" class="btn btn-primary"
                                                        onclick="return confirm('Yakin ingin mengirim pengajuan ini ke IDUKA?')">
                                                        Kirim
                                                    </button>
                                                </form>
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

{{-- @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn-proses');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const iduka_id = this.dataset.iduka_id; // Pastikan iduka_id ada dalam data tombol

                if (!iduka_id) {
                    alert('IDUKA ID tidak valid.');
                    return;
                }

                if (confirm('Yakin ingin mengirim pengajuan ini ke IDUKA?')) {
                    axios.post(`/review/pengajuan/proses/${id}`, {
                            iduka_id: iduka_id
                        })
                        .then(response => {
                            alert(response.data.message);
                            this.textContent = 'Sudah';
                            this.disabled = true;
                            this.classList.remove('btn-primary');
                            this.classList.add('btn-success');
                        })
                        .catch(error => {
                            if (error.response.status === 409) {
                                alert('Data sudah dikirim sebelumnya.');
                            } else {
                                alert('Terjadi kesalahan saat mengirim.');
                            }
                        });
                }
            });
        });
    });
</script>

@endpush --}}
