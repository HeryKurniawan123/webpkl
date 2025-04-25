@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="card mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Review Pengajuan IDUKA</h5>
                        <a class="nav-link btn btn-success" href="{{ route('kaprog.review.histori') }}">
                            <i class="fas fa-history me-2"></i> Histori Pengajuan
                        </a>
                    </div>
                    
                </div>

                <div class="col-md-12 mt-3">
                    @if($pengajuanUsulans->isEmpty())
                    <p class="text-center">Tidak ada pengajuan yang tersedia.</p>
                    @else
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

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
                            // Filter hanya pengajuan dengan status 'proses' atau belum diproses
                            $filteredPengajuan = $pengajuanGroup->filter(function($item) {
                                return $item->status === 'sudah';
                            });
                        @endphp
                        
                        @if($filteredPengajuan->count() > 0)
                        <div class="card mb-3 shadow-sm" style="padding: 30px; border-radius: 10px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="mb-0" style="font-size: 18px"><strong>{{ $pengajuanGroup->first()->iduka->nama }}</strong></div>
                                    <small class="text-muted">{{ $filteredPengajuan->count() }} siswa mengajukan ke sini</small>
                                </div>
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <a href="{{ route('kaprog.review.reviewdetail', ['iduka_id' => $iduka_id]) }}" class="btn btn-primary rounded-pill">Detail</a>
                                    <form action="{{ route('kaprog.review.kirimSemua', ['iduka_id' => $iduka_id]) }}" method="POST" onsubmit="return confirm('Yakin ingin mengirim semua pengajuan ke IDUKA ini?');">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            Kirim Semua Pengajuan
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