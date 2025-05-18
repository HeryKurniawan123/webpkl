@extends('layout.main')

@section('content')
<style>
  .card-custom {
    border-radius: 1rem;
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.05);
    transition: 0.3s;
    min-width: 0;
  }

  .card-custom:hover {
    transform: translateY(-3px);
  }

  .icon-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: var(--bs-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
  }

  .grid-custom {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    justify-content: end;
  }
</style>

<div class="container-fluid"><br>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      {{-- Welcome Card --}}
      <div class="row">
        <div class="col-lg-12 mb-3 order-0">
          <div class="card">
            <div class="d-flex align-items-end row">
              <div class="col-sm-7">
                <div class="card-body">
                  <h5 class="card-title text-primary">Halo {{ Auth::user()->name }}! 🎉</h5>
                  <p class="mb-4">Data kamu belum terisi sepenuhnya nih. Ayo isi terlebih dahulu!</p>
                </div>
              </div>
              <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-4">
                  <img
                    src="{{ asset('snet/assets/img/illustrations/man-with-laptop-light.png') }}"
                    height="140"
                    alt="View Badge User"
                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Cards --}}
      <div class="row mt-3">
        <div class="grid-custom">

          <div class="card card-custom">
            <div class="d-flex align-items-center p-3">
              <div class="icon-wrapper me-3">
                <i class="fas fa-lightbulb"></i>
              </div>
              <div>
                <h6 class="text-muted mb-0">Jumlah Usulan</h6>
                <h4 class="mb-0 fw-bold text-primary">125</h4>
              </div>
            </div>
          </div>

          <div class="card card-custom">
            <div class="d-flex align-items-center p-3">
              <div class="icon-wrapper me-3">
                <i class="fas fa-paper-plane"></i>
              </div>
              <div>
                <h6 class="text-muted mb-0">Jumlah Pengajuan</h6>
                <h4 class="mb-0 fw-bold text-primary">97</h4>
              </div>
            </div>
          </div>

          <div class="card card-custom">
            <div class="d-flex align-items-center p-3">
              <div class="icon-wrapper me-3">
                <i class="fas fa-check-circle"></i>
              </div>
              <div>
                <h6 class="text-muted mb-0">Jumlah Diterima</h6>
                <h4 class="mb-0 fw-bold text-primary">80</h4>
              </div>
            </div>
          </div>

          <div class="card card-custom">
            <div class="d-flex align-items-center p-3">
              <div class="icon-wrapper me-3">
                <i class="fas fa-times-circle"></i>
              </div>
              <div>
                <h6 class="text-muted mb-0">Jumlah Ditolak</h6>
                <h4 class="mb-0 fw-bold text-primary">17</h4>
              </div>
            </div>
          </div>

        </div>
      </div>

      {{-- Chart --}}
    <div class="card mt-4">
        <div class="card-body">
          <h5 class="card-title text-center">Statistik Pengajuan</h5>
          <canvas id="statistikChart" height="100"></canvas>
        </div>
    </div>


    </div>
  </div>
</div>
@endsection

{{-- SweetAlert --}}
@if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: "{{ session('success') }}",
    showConfirmButton: false,
    timer: 2000,
    customClass: {
      popup: 'animate__animated animate__fadeInDown'
    }
  });
</script>
@endif

@if(session('error'))
<script>
  Swal.fire({
    icon: 'error',
    title: 'Oops!',
    text: "{{ session('error') }}",
    showConfirmButton: false,
    timer: 2500,
    customClass: {
      popup: 'animate__animated animate__shakeX'
    }
  });
</script>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('statistikChart').getContext('2d');
    const statistikChart = new Chart(ctx, {
      type: 'bar', // tipe grafik ieu batang
      data: {
        labels: ['Usulan', 'Pengajuan', 'Diterima', 'Ditolak'], // label sesuai card
        datasets: [{
          label: 'Jumlah',
          data: [125, 97, 80, 17], // data sesuai card
          backgroundColor: [
            'rgba(102, 126, 234, 0.8)', //biru ungu
            'rgba(54, 162, 235, 0.8)',  // biru muda
            'rgba(75, 192, 192, 0.8)',  // hijau toska
            'rgba(255, 99, 132, 0.8)'   // merah
          ],
          borderRadius: 10,
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 10 // supaya langkah y axis kelihatan rapi
            }
          }
        }
      }
    });
  });
</script>

