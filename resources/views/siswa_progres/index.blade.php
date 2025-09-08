@extends('layouts.app')

@section('content')
<div class="container">
    <h5 class="fw-bold mb-3">
        <i class="bx bx-bar-chart-alt-2 text-primary"></i>
        Statistik Usulan & Pengajuan
    </h5>

    {{-- Kartu Statistik --}}
    <div class="row mb-4">
        <!-- Jumlah Usulan -->
        <div class="col-md-3">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <i class="bx bx-file text-primary fs-2 mb-2"></i>
                    <h6 class="text-muted">Jumlah Usulan</h6>
                    <h3 class="fw-bold text-primary">{{ $totalUsulan }}</h3>
                </div>
            </div>
        </div>

        <!-- Usulan Diterima -->
        <div class="col-md-3">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <i class="bx bx-check-circle text-success fs-2 mb-2"></i>
                    <h6 class="text-muted">Usulan Diterima</h6>
                    <h3 class="fw-bold text-success">{{ $totalUsulanDiterima }}</h3>
                </div>
            </div>
        </div>

        <!-- Usulan Ditolak -->
        <div class="col-md-3">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <i class="bx bx-x-circle text-danger fs-2 mb-2"></i>
                    <h6 class="text-muted">Usulan Ditolak</h6>
                    <h3 class="fw-bold text-danger">{{ $totalUsulanDitolak }}</h3>
                </div>
            </div>
        </div>

        <!-- Jumlah Pengajuan -->
        <div class="col-md-3">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <i class="bx bx-send text-info fs-2 mb-2"></i>
                    <h6 class="text-muted">Jumlah Pengajuan</h6>
                    <h3 class="fw-bold text-info">{{ $totalPengajuan }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Statistik --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold">
            <i class="bx bx-pie-chart-alt-2 text-primary"></i> Grafik Usulan & Pengajuan
        </div>
        <div class="card-body">
            <canvas id="statistikChart" height="120"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('statistikChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jumlah Usulan', 'Diterima', 'Ditolak', 'Pengajuan'],
            datasets: [{
                label: 'Jumlah',
                data: [
                    {{ $totalUsulan }},
                    {{ $totalUsulanDiterima }},
                    {{ $totalUsulanDitolak }},
                    {{ $totalPengajuan }}
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',  // biru
                    'rgba(75, 192, 192, 0.7)',  // hijau
                    'rgba(255, 99, 132, 0.7)',  // merah
                    'rgba(255, 206, 86, 0.7)'   // kuning
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endsection
