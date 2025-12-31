@extends('maintemplatedashboard')

@section('content')

    {{-- WRAPPER UTAMA: Flex container untuk Sidebar (Kiri) dan Content (Kanan) --}}
    <div id="wrapper" class="d-flex w-100 overflow-hidden">
        
        {{-- 1. SIDEBAR --}}
        {{-- Sidebar akan otomatis mengisi tinggi karena flex-stretch --}}
        @include('partials.sidebardokter') 

        {{-- 2. CONTENT WRAPPER --}}
        {{-- Flex-column agar Topbar, Konten, dan Footer tersusun vertikal --}}
        <div id="content-wrapper" class="d-flex flex-column w-100 min-vh-100 bg-light position-relative">
            
            {{-- A. TOPBAR (NAVIGASI ATAS) --}}
            {{-- Ini adalah kunci agar tombol logout ada di KANAN ATAS --}}
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm px-4">

                {{-- Tombol Toggle Sidebar (Muncul hanya di Mobile) --}}
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
                    <i class="fa fa-bars text-medical"></i>
                </button>

                {{-- JUDUL HALAMAN (Opsional, di kiri) --}}
                <h5 class="d-none d-sm-block m-0 font-weight-bold text-secondary">Dashboard Dokter</h5>

                {{-- TOPBAR NAVBAR (Sisi Kanan) --}}
                {{-- 'ms-auto' adalah kunci untuk mendorong elemen ke kanan mentok --}}
                <ul class="navbar-nav ms-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>

                    {{-- ITEM PROFIL USER / LOGOUT --}}
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="me-2 d-none d-lg-inline text-gray-600 small fw-bold">
                                {{ strtoupper(Auth::user()->name) }}
                            </span>
                            {{-- Avatar Logic --}}
                            @if(Auth::user()->image != null)
                                <img class="img-profile rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #0f766e;" src="{{asset('/images/'.Auth::user()->image)}}">
                            @else
                                <div class="rounded-circle bg-medical text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; font-weight: bold;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </a>

                        {{-- DROPDOWN MENU --}}
                        <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in border-0" aria-labelledby="userDropdown">
                            <h6 class="dropdown-header">
                                Akun Dokter
                            </h6>
                            <a class="dropdown-item" href="/profile-dokter">
                                <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
                                Profil Saya
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="/logout" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            {{-- END TOPBAR --}}


            {{-- B. MAIN CONTENT --}}
            <div id="content" class="flex-grow-1">
                
                {{-- Container-fluid agar FULL WIDTH mengikuti lebar layar --}}
                <div class="container-fluid px-4">

                    {{-- WELCOME BANNER --}}
                    <div class="card border-0 shadow rounded-4 mb-4 bg-gradient-medical text-white overflow-hidden">
                        <div class="card-body p-4 p-md-5 position-relative">
                            {{-- Dekorasi Icon Background --}}
                            <div class="position-absolute top-50 end-0 translate-middle-y me-4 opacity-25 d-none d-md-block">
                                <i class="fa-solid fa-user-doctor" style="font-size: 9rem; color: rgba(255,255,255,0.3);"></i>
                            </div>
                            
                            <div class="position-relative" style="z-index: 1;">
                                <h2 class="fw-bold display-6">Selamat Datang!</h2>
                                <p class="lead mb-2 fs-4">
                                    Hai, <strong>{{ strtoupper(Auth()->user()->name) }}</strong>.
                                </p>
                                <p class="mb-0 opacity-75" style="max-width: 600px;">
                                    Selamat datang di Dashboard dr. Em. Silakan pilih menu di sidebar untuk mengelola data pasien.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- STATS CARDS ROW --}}
                    <div class="row g-4"> 
                        <div class="col-12 col-md-6 col-xl-4">
                            <a href="/lihat-reservasi" class="text-decoration-none card-hover-effect d-block">
                                <div class="card border-0 shadow-sm rounded-4 h-100">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <div class="text-uppercase text-muted small fw-bold mb-1 tracking-wide">
                                                    Reservasi Hari Ini
                                                </div>
                                                <div class="h2 fw-bold text-medical mb-0">
                                                    {{ $countallreservasi ?? '0' }}
                                                </div>
                                                <small class="text-muted">{{ date('d F Y') }}</small>
                                            </div>
                                            <div class="icon-shape bg-medical-soft text-medical p-3 rounded-4">
                                                <i class="fa-solid fa-calendar-check fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- END MAIN CONTENT --}}

            {{-- C. FOOTER --}}
            <footer class="bg-white py-3 mt-auto border-top">
                <div class="container-fluid">
                    <div class="text-center text-muted small">
                        <span>&copy; {{ date('Y') }} Kelompok 12 SI UA - Dashboard dr. Em</span>
                    </div>
                </div>
            </footer>

        </div>
    </div>

    {{-- CSS TAMBAHAN AGAR RAPI --}}
    <style>
        /* Setup Warna Medis (Teal) */
        :root {
            --medical-primary: #0f766e;
            --medical-light: #14b8a6;
            --medical-soft: #ccfbf1;
        }

        /* Full Screen Fix */
        html, body {
            height: 100%;
            overflow-x: hidden;
        }

        /* Topbar Styling */
        .topbar {
            height: 4.375rem;
            z-index: 10;
        }

        /* Warna Custom */
        .bg-medical { background-color: var(--medical-primary); }
        .text-medical { color: var(--medical-primary) !important; }
        .bg-medical-soft { background-color: var(--medical-soft) !important; }

        .bg-gradient-medical {
            background: linear-gradient(135deg, var(--medical-primary) 0%, var(--medical-light) 100%) !important;
        }

        /* Hover Effect */
        .card-hover-effect {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover-effect:hover .card {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0,0,0,0.1)!important;
        }

        /* Icon Shape Box */
        .icon-shape {
            width: 70px; height: 70px;
            display: flex; align-items: center; justify-content: center;
        }
    </style>

@endsection