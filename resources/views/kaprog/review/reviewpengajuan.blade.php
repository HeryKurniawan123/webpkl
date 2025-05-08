@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="card mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Review Pengajuan Institusi / Perusahaan</h5>
                        <a class="nav-link btn btn-success btn-sm" href="{{ route('kaprog.review.histori') }}">
                            <i class="fas fa-history me-2 "></i> History Pengajuan
                        </a>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    @if($pengajuanUsulans->isEmpty())
                    <div class="alert alert-info text-center mt-4" role="alert">
                        🎉 Semua pengajuan sudah berhasil dikirim ke Iduka, dan tidak ada pengajuan yang tersedia.
                    </div>
                    @else

                    @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @foreach($pengajuanUsulans as $iduka_id => $pengajuanGroup)
                    @php
                    $filteredPengajuan = $pengajuanGroup->filter(function($item) {
                    return $item->status === 'sudah';
                    });
                    @endphp

                    @if($filteredPengajuan->count() > 0)
                    <div class="card mb-3 shadow-sm" style="padding: 30px; border-radius: 10px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="mb-0" style="font-size: 18px"><strong>{{ $pengajuanGroup->first()->iduka->nama }}</strong></div>
                                @php
                                $jumlahMenunggu = $pengajuanGroup->where('dikirim', 'menunggu')->count();
                                @endphp

                                <small class="text-muted">{{ $filteredPengajuan->count() }} siswa mengajukan ke sini</small>
                                @if($jumlahMenunggu > 0)
                                <div class="text-danger mt-1" style="font-size: 13px;">
                                    ⚠️ {{ $jumlahMenunggu }} siswa sedang mengajukan pembatalan (menunggu)
                                </div>
                                @endif

                            </div>

                            {{-- Desktop View: Inline Buttons --}}
                            <div class="d-flex" style="gap: 10px; align-items: center; min-height: 100%; height: auto;">
                                <a href="{{ route('kaprog.review.reviewdetail', ['iduka_id' => $iduka_id]) }}" class="btn btn-primary rounded-pill">Detail</a>

                                <form action="{{ route('kaprog.review.kirimSemua', ['iduka_id' => $iduka_id]) }}" method="POST" class="formKirimSemua" data-menunggu="{{ $jumlahMenunggu }}">
                                    @csrf
                                    <button type="button" class="btn btn-primary rounded-pill btn-kirim-semua">
                                        Kirim Semua
                                    </button>
                                </form>


                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kirimButtons = document.querySelectorAll('.btn-kirim-semua');

        kirimButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                const jumlahMenunggu = parseInt(form.getAttribute('data-menunggu'));

                if (jumlahMenunggu > 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tidak dapat mengirim!',
                        text: 'Terdapat siswa yang sedang mengajukan pembatalan.',
                        confirmButtonColor: '#d33'
                    });
                } else {
                    Swal.fire({
                        title: 'Yakin?',
                        text: "Ingin mengirim semua pengajuan ke INSTITUSI ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Kirim!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            });
        });
    });
</script>

@if(session('success'))
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: '{{ session('
        success ') }}',
        icon: 'success',
        timer: 1500,
        showConfirmButton: false
    });
</script>
@endif