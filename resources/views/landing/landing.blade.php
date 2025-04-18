<!--
=========================================================
* Argon Dashboard 3 - v2.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('tmp/assets/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{ asset('tmp/assets/img/favicon.png')}}">
  <title>
    Argon Dashboard 3 by Creative Tim
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  {{-- bootstrap cdn icon --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('tmp/assets/css/argon-dashboard.css?v=2.1.0')}}" rel="stylesheet" />

  <link rel="stylesheet" href="style.css">
</head>

<body class="g-sidenav-show">
    <div class="min-height-300 bg-dark position-absolute w-100"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top rounded-3 mx-auto mt-3" style="z-index: 999; max-width: 1500px; left: 0; right: 0;">
        <div class="container-fluid">
        <div class="card w-100 m-0 border-0 bg-transparent">
            <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">WEB PKL</h5>
            <button class="btn btn-danger">Hai</button>
            </div>
        </div>
        </div>
    </nav>
    <!-- End Navbar -->
    
    <!-- Main content -->
    <main class="main-content position-relative border-radius-lg pt-5 mt-5">
        <div class="container mt-5">
            <div class="card shadow-lg overflow-hidden">
                <div class="row g-0 d-flex align-items-center h-100">
                    
                    <!-- Kolom Teks -->
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <div class="p-5 text-center text-section w-100">
                            <h2 class="animated-text">Hallo, Selamat Datang di</h2>
                            <p class="animated-text delay">Inilah tempat di mana kamu bisa menemukan gambar-gambar menarik!</p>
                        </div>
                    </div>
    
                    <div class="col-md-6 h-100">
                        <div id="carouselExample" class="carousel slide h-100" data-bs-ride="carousel" data-bs-interval="3000">
                            <div class="carousel-inner h-100">
                                <div class="carousel-item active h-100">
                                    <img src="{{ asset('images/bljr.png') }}" class="d-block w-100 h-100 object-fit-cover" alt="...">
                                </div>
                                <div class="carousel-item h-100">
                                    <img src="{{ asset('images/bljrr.png') }}" class="d-block w-100 h-100 object-fit-cover" alt="...">
                                </div>
                            </div>
    
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Sebelumnya</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Selanjutnya</span>
                            </button>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    </main>    
    
    
  <!--   Core JS Files   -->
  <script src="{{ asset('tmp/assets/js/core/popper.min.js')}}"></script>
  <script src="{{ asset('tmp/assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{ asset('tmp/assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{ asset('tmp/assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <script src="{{ asset('tmp/assets/js/plugins/chartjs.min.js')}}"></script>
  <script src="script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Mobile apps",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#fbfbfb',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#ccc',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('tmp/assets/js/argon-dashboard.min.js?v=2.1.0')}}"></script>
</body>

</html>