@extends('maintemplatedashboard')

@section('content')

{{-- STRUKTUR UTAMA (Full Screen Layout) --}}
<div id="wrapper" class="d-flex w-100 overflow-hidden">

    {{-- 1. SIDEBAR STAFF --}}
    {{-- Menggunakan @include agar sidebar masuk ke dalam layout, bukan extends --}}
    @include('partials.sidebarstaff') 

    {{-- 2. CONTENT WRAPPER --}}
    <div id="content-wrapper" class="d-flex flex-column w-100 min-vh-100 bg-light position-relative">
        
        {{-- TOPBAR (Satu-satunya Menu Profil) --}}
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm px-4" style="z-index: 1000;">
            
            {{-- Tombol Toggle Sidebar (Mobile) --}}
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
                <i class="fa fa-bars text-royal"></i>
            </button>

            {{-- Judul Halaman --}}
            <h5 class="d-none d-sm-block m-0 fw-bold text-secondary">Dashboard Staff</h5>

            {{-- Menu Kanan (Profil) --}}
            <ul class="navbar-nav ms-auto">
                <div class="topbar-divider d-none d-sm-block"></div>
                
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="me-2 d-none d-lg-inline text-gray-600 small fw-bold">
                            {{ strtoupper(auth()->user()->name) }}
                        </span>
                        @if(auth()->user()->image != null)
                            <img class="img-profile rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #2563eb;" src="{{asset('/images/'.auth()->user()->image)}}">
                        @else
                            <div class="rounded-circle bg-royal text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; font-weight: bold;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </a>
                    
                    {{-- Dropdown Menu --}}
                    <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in border-0" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Profil Saya
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw me-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        {{-- MAIN CONTENT --}}
        <div id="content" class="flex-grow-1">
            <div class="container-fluid px-4">

                {{-- BANNER WELCOME (Royal Theme) --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 bg-gradient-royal text-white overflow-hidden">
                    <div class="card-body p-4 p-lg-5 position-relative">
                        <div class="position-absolute bottom-0 end-0 mb-n3 me-n3 opacity-25 d-none d-md-block">
                            <i class="fa-solid fa-hospital-user" style="font-size: 10rem; color: rgba(255,255,255,0.2);"></i>
                        </div>
                        <div class="position-relative" style="z-index: 1;">
                            <h2 class="fw-bold mb-2">Selamat Datang, {{ explode(' ', auth()->user()->name)[0] }}!</h2>
                            <p class="lead mb-3 opacity-90">Semangat melayani! Kelola data klinik dengan efisien.</p>
                            <p class="mb-0 small text-white-50">Silakan pilih menu di bawah atau di samping untuk mengelola data.</p>
                        </div>
                    </div>
                </div>

                {{-- STATISTIK CARDS --}}
                <div class="row g-4 mb-4">
                    
                    {{-- Card 1: Reservasi Hari Ini --}}
                    <div class="col-md-6 col-xl-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100 card-hover-royal">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon-box bg-royal-soft text-royal rounded-4">
                                            <i class="fa-solid fa-calendar-day fa-2x"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted text-uppercase fs-xs fw-bold mb-1">Reservasi Hari Ini</h6>
                                        <div class="d-flex align-items-baseline">
                                            <h2 class="mb-0 fw-bold text-dark me-2">{{ $countreservasitoday ?? 0 }}</h2>
                                            <span class="badge bg-warning text-dark rounded-pill">{{ date('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Jadwal Bulan Ini --}}
                    <div class="col-md-6 col-xl-6">
                        <div class="card border-0 shadow-sm rounded-4 h-100 card-hover-royal">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="icon-box bg-gold-soft text-warning rounded-4">
                                            <i class="fa-regular fa-calendar-days fa-2x"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="text-muted text-uppercase fs-xs fw-bold mb-1">Jadwal Bulan Ini</h6>
                                        <div class="d-flex align-items-baseline">
                                            <h2 class="mb-0 fw-bold text-dark me-2">{{ $countjadwalmonthly ?? 0 }}</h2>
                                            <span class="badge bg-primary-subtle text-primary rounded-pill">{{ date('F Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- GRAFIK --}}
                <div class="card border-0 shadow-sm rounded-4 mb-5">
                    <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between rounded-top-4">
                        <h6 class="m-0 fw-bold text-royal">
                            <i class="fa-solid fa-chart-line me-2"></i> Grafik Reservasi Bulanan
                        </h6>
                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#chartCollapse" aria-expanded="true">
                            <i class="bi bi-arrows-collapse"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="chartCollapse">
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height:40vh; width:100%">
                                <canvas id="chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- FOOTER --}}
        <footer class="bg-white py-3 mt-auto border-top">
            <div class="container-fluid">
                <div class="text-center text-muted small">
                    <span>&copy; {{ date('Y') }} Kelompok 4 SEHATIN</span>
                </div>
            </div>
        </footer>

    </div>
</div>

{{-- SCRIPT CHART --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = [
      'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
    ];

    const data = {
      labels: labels,
      datasets: [{
        label: 'Reservasi Tahun {{ date("Y") }}',
        backgroundColor: 'rgba(37, 99, 235, 0.1)', // Warna Royal Blue Transparan
        borderColor: '#2563eb', // Royal Blue Solid
        borderWidth: 2,
        pointBackgroundColor: '#ffffff',
        pointBorderColor: '#2563eb',
        pointHoverBackgroundColor: '#2563eb',
        pointHoverBorderColor: '#ffffff',
        fill: true,
        tension: 0.4, 
        data: [
            {{ $countAllReservasi[1] ?? 0 }}, {{ $countAllReservasi[2] ?? 0 }}, {{ $countAllReservasi[3] ?? 0 }},
            {{ $countAllReservasi[4] ?? 0 }}, {{ $countAllReservasi[5] ?? 0 }}, {{ $countAllReservasi[6] ?? 0 }},
            {{ $countAllReservasi[7] ?? 0 }}, {{ $countAllReservasi[8] ?? 0 }}, {{ $countAllReservasi[9] ?? 0 }},
            {{ $countAllReservasi[10] ?? 0 }}, {{ $countAllReservasi[11] ?? 0 }}, {{ $countAllReservasi[12] ?? 0 }}
        ],
      }]
    };

    const config = {
      type: 'line',
      data: data,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: true, position: 'top' }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { borderDash: [5, 5], color: '#f0f0f0' }
            },
            x: {
                grid: { display: false }
            }
        }
      }
    };

    const chart = new Chart(
      document.getElementById('chart'),
      config
    );
</script>

{{-- CSS KHUSUS DASHBOARD STAFF (ROYAL THEME) --}}
<style>
    /* Variabel Warna Royal Blue & Gold */
    :root {
        --royal-blue: #2563eb;
        --royal-dark: #1e40af;
        --royal-soft: #eff6ff;
        --gold-soft: #fffbeb;
        --gold-dark: #d97706;
    }

    /* Layout Fix */
    html, body { 
        height: 100%; 
        overflow-x: hidden; 
    }
    
    #wrapper { overflow: visible !important; }

    /* Gradient Banner */
    .bg-gradient-royal {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    }

    /* Icon Box */
    .icon-box {
        width: 70px; height: 70px; display: flex; align-items: center; justify-content: center;
    }
    .bg-royal-soft { background-color: var(--royal-soft) !important; color: var(--royal-blue) !important; }
    .bg-gold-soft { background-color: var(--gold-soft) !important; color: var(--gold-dark) !important; }
    
    .bg-royal { background-color: var(--royal-blue) !important; }
    .text-royal { color: var(--royal-blue) !important; }
    .fs-xs { font-size: 0.75rem; letter-spacing: 0.05em; }

    /* Topbar */
    .topbar { height: 4.375rem; }
    
    /* Hover Card Effect */
    .card-hover-royal { transition: transform 0.2s ease-in-out; }
    .card-hover-royal:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1.5rem rgba(37, 99, 235, 0.15)!important;
        border-bottom: 4px solid var(--royal-blue) !important;
    }
</style>

@endsection