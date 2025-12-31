@extends('maintemplatedashboard')

@section('content')

{{-- CSS KHUSUS DASHBOARD FULL --}}
<style>
    /* 1. Variabel Warna Soft */
    :root {
        --indigo-primary: #4e73df;
        --soft-blue: #e7f1ff;   /* Untuk Reservasi Baru */
        --soft-green: #e9f7ef;  /* Untuk Riwayat Medis */
        --soft-orange: #fff8e1; /* Untuk Riwayat Reservasi */
        --soft-purple: #f3e5f5; /* Untuk Profil */
        --soft-teal: #e0f2f1;   /* Untuk Halaman Depan */
    }

    body {
        background-color: #f8f9fc;
    }

    /* 2. Styling Card Menu */
    .menu-card {
        border: none;
        border-radius: 1rem;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        background-color: #fff;
        height: 100%;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    /* Efek Hover Mengangkat & Shadow */
    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        border: 1px solid var(--indigo-primary) !important;
    }

    /* Icon Container */
    .icon-box {
        width: 80px; 
        height: 80px; 
        display: flex; 
        align-items: center; 
        justify-content: center;
        border-radius: 50%;
        margin-bottom: 1rem;
        transition: transform 0.3s;
    }
    
    .menu-card:hover .icon-box {
        transform: scale(1.1);
    }

    /* Warna Spesifik per Menu */
    .bg-soft-blue { background-color: var(--soft-blue); color: #4e73df; }
    .bg-soft-green { background-color: var(--soft-green); color: #1cc88a; }
    .bg-soft-orange { background-color: var(--soft-orange); color: #f6c23e; }
    .bg-soft-purple { background-color: var(--soft-purple); color: #6f42c1; }
    .bg-soft-teal { background-color: var(--soft-teal); color: #20c9a6; }

    /* Banner Gradient */
    .banner-welcome {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border-radius: 1rem;
        color: white;
    }

    /* Judul Menu */
    .menu-title {
        font-weight: 700;
        color: #5a5c69;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    .menu-desc {
        color: #858796;
        font-size: 0.85rem;
    }
</style>

{{-- CONTAINER UTAMA (TANPA WRAPPER SIDEBAR) --}}
<div class="d-flex flex-column min-vh-100">

    {{-- 1. NAVBAR (FULL WIDTH) --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4 px-4 py-3">
        <div class="container-fluid">
            
            {{-- Brand / Logo --}}
            <a class="navbar-brand d-flex align-items-center" href="/dashboard">
                <img src="/img/logo.png" alt="Logo" width="40" height="40" class="me-2">
                <div class="d-flex flex-column">
                    <span class="fw-bold text-primary" style="line-height: 1;">SEHATIN</span>
                    <small class="text-muted" style="font-size: 0.7rem;">Dashboard Pasien</small>
                </div>
            </a>

            {{-- User Profil (Kanan) --}}
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="d-none d-md-block text-end me-3">
                            <span class="d-block text-gray-600 small fw-bold">{{ strtoupper(auth()->user()->name) }}</span>
                            <span class="d-block text-xs text-muted">Pasien</span>
                        </div>
                        @if(auth()->user()->image != null)
                            <img class="img-profile rounded-circle" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #4e73df;" src="{{asset('/images/'.auth()->user()->image)}}">
                        @else
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px; font-weight: bold;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </a>
                    
                    {{-- Dropdown Menu --}}
                    <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in border-0" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="/profile">
                            <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Profil Saya
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw me-2"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    {{-- 2. KONTEN MENU --}}
    <div class="container pb-5">

        {{-- BANNER SELAMAT DATANG --}}
        <div class="card border-0 shadow-sm banner-welcome mb-5">
            <div class="card-body p-4 p-lg-5 d-flex align-items-center justify-content-between position-relative overflow-hidden">
                <div style="z-index: 2;">
                    <h2 class="fw-bold mb-2">Halo, {{ explode(' ', auth()->user()->name)[0] }}! 👋</h2>
                    <p class="lead mb-0 opacity-75">Apa yang ingin Anda lakukan hari ini?</p>
                </div>
                {{-- Hiasan Background --}}
                <div class="position-absolute end-0 me-5 opacity-25 d-none d-md-block">
                    <i class="fa-solid fa-hospital-user" style="font-size: 8rem;"></i>
                </div>
            </div>
        </div>

        {{-- GRID MENU (5 ICON) --}}
        <div class="row g-4 justify-content-center">

            {{-- 1. RESERVASI BUAT BARU --}}
            <div class="col-md-6 col-lg-4">
                <a href="/buat-reservasi" class="card shadow-sm h-100 menu-card p-4 text-center">
                    <div class="d-flex justify-content-center">
                        <div class="icon-box bg-soft-blue">
                            <i class="fa-solid fa-calendar-plus fa-3x"></i>
                        </div>
                    </div>
                    <h5 class="menu-title">Buat Reservasi Baru</h5>
                    <p class="menu-desc mb-0">Daftar antrian periksa dokter secara online.</p>
                </a>
            </div>

            {{-- 2. RIWAYAT PEMERIKSAAN --}}
            <div class="col-md-6 col-lg-4">
                <a href="/rekam-medis" class="card shadow-sm h-100 menu-card p-4 text-center">
                    <div class="d-flex justify-content-center">
                        <div class="icon-box bg-soft-green">
                            <i class="fa-solid fa-file-medical fa-3x"></i>
                        </div>
                    </div>
                    <h5 class="menu-title">Riwayat Pemeriksaan</h5>
                    <p class="menu-desc mb-0">Lihat catatan medis dan diagnosa dokter.</p>
                </a>
            </div>

            {{-- 3. RIWAYAT RESERVASI --}}
            <div class="col-md-6 col-lg-4">
                <a href="/reservasi" class="card shadow-sm h-100 menu-card p-4 text-center">
                    <div class="d-flex justify-content-center">
                        <div class="icon-box bg-soft-orange">
                            <i class="fa-solid fa-clock-rotate-left fa-3x"></i>
                        </div>
                    </div>
                    <h5 class="menu-title">Riwayat Reservasi</h5>
                    <p class="menu-desc mb-0">Cek status antrian dan jadwal kunjungan Anda.</p>
                </a>
            </div>

            {{-- 4. UBAH PROFIL PASIEN --}}
            <div class="col-md-6 col-lg-4">
                <a href="/profile" class="card shadow-sm h-100 menu-card p-4 text-center">
                    <div class="d-flex justify-content-center">
                        <div class="icon-box bg-soft-purple">
                            <i class="fa-solid fa-user-pen fa-3x"></i>
                        </div>
                    </div>
                    <h5 class="menu-title">Ubah Profil</h5>
                    <p class="menu-desc mb-0">Update data diri, foto, dan kata sandi.</p>
                </a>
            </div>

            {{-- 5. HALAMAN UTAMA --}}
            <div class="col-md-6 col-lg-4">
                <a href="/" class="card shadow-sm h-100 menu-card p-4 text-center">
                    <div class="d-flex justify-content-center">
                        <div class="icon-box bg-soft-teal">
                            <i class="fa-solid fa-house-medical fa-3x"></i>
                        </div>
                    </div>
                    <h5 class="menu-title">Halaman Depan</h5>
                    <p class="menu-desc mb-0">Kembali ke halaman landing page utama.</p>
                </a>
            </div>

        </div> 
        {{-- END ROW --}}

    </div>

    {{-- FOOTER --}}
    <footer class="bg-white py-4 mt-auto border-top">
        <div class="container text-center text-muted small">
            <span>&copy; {{ date('Y') }} Kelompok 4 SEHATIN - All Rights Reserved</span>
        </div>
    </footer>

</div>

{{-- MODAL LOGOUT --}}
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Keluar</h5>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4 text-center">
                Apakah Anda yakin ingin mengakhiri sesi ini?
            </div>
            <div class="modal-footer justify-content-center">
                <button class="btn btn-secondary px-4" type="button" data-bs-dismiss="modal">Batal</button>
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger px-4">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection