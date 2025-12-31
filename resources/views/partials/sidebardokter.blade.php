<style>
    /* 1. Warna Latar & Gradient */
    .bg-gradient-medical {
        background-color: #115e59; /* Warna dasar solid */
        background-image: linear-gradient(180deg, #0f766e 0%, #115e59 100%);
        background-size: cover;
        background-repeat: no-repeat;
    }

    /* 2. Layout Sidebar Full Height Responsive */
    .sidebar {
        min-height: 100vh;
        height: auto;
        display: flex;
        flex-direction: column;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }

    /* 3. RESET STYLE SIDEBAR DOKTER */
    #accordionSidebar .nav-item {
        margin-bottom: 5px;
        padding: 0 10px;
    }

    #accordionSidebar .nav-item .nav-link {
        border-radius: 8px;
        color: rgba(255, 255, 255, 0.85) !important;
        font-weight: 500;
        width: 100%;
        
        /* FLEXBOX UNTUK JARAK YANG KUAT */
        display: flex !important;
        align-items: center !important;
        gap: 15px !important; /* Jarak modern antar elemen */
        
        transition: all 0.2s ease;
        padding: 0.8rem 1rem;
        text-align: left;
    }

    /* 4. Efek Hover & Active */
    #accordionSidebar .nav-item .nav-link:hover, 
    #accordionSidebar .nav-item .nav-link.active {
        background-color: rgba(255, 255, 255, 0.15);
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        font-weight: 700;
    }

    /* 5. Icon Styling - PAKSA JARAK */
    #accordionSidebar .nav-item .nav-link i {
        font-size: 1rem;
        margin-right: 10px !important; /* Tambahan margin kanan */
        width: 25px !important;        /* Lebar fix agar icon sejajar */
        text-align: center;
        color: rgba(255, 255, 255, 0.75);
    }
    
    #accordionSidebar .nav-item .nav-link:hover i,
    #accordionSidebar .nav-item .nav-link.active i {
        color: #ffffff;
    }
    
    #accordionSidebar .nav-item .nav-link span {
        font-size: 0.9rem;
    }

    /* 6. Brand & Divider */
    #accordionSidebar .sidebar-brand {
        height: 4.375rem;
        text-decoration: none;
        font-size: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05rem;
        color: #fff;
        background-color: rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #accordionSidebar .sidebar-divider {
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        margin: 1rem 1rem 1rem;
    }

    #accordionSidebar .sidebar-heading {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255, 255, 255, 0.5);
        padding: 0 1.5rem;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    /* Responsif: Toggler di Bawah */
    .text-center.d-none.d-md-inline {
        margin-top: auto;
        padding-bottom: 2rem;
    }
</style>

<ul class="navbar-nav bg-gradient-medical sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- LOGO / BRAND --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center my-0" href="/dashboard-dokter">
        <div class="sidebar-brand-icon">
            <img src="/img/logo.png" alt="Logo" width="45" style="filter: drop-shadow(0 2px 2px rgba(0,0,0,0.2));">
        </div>
        <div class="sidebar-brand-text mx-3">dr. Em</div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- MENU UTAMA --}}
    <div class="sidebar-heading">
        Menu Utama
    </div>

    <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard-dokter') ? 'active' : '' }}" href="/dashboard-dokter">
            <i class="fa-solid fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::is('lihat-pasien*') ? 'active' : '' }}" href="/lihat-pasien">
            <i class="fa-solid fa-user-injured"></i>
            <span>Data Pasien</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::is('lihat-jadwal*') ? 'active' : '' }}" href="/lihat-jadwal">
            <i class="fa-solid fa-calendar-check"></i>
            <span>Jadwal Praktek</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::is('lihat-reservasi*') ? 'active' : '' }}" href="/lihat-reservasi">
            <i class="fa-solid fa-clipboard-list"></i>
            <span>Daftar Reservasi</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Request::is('lihat-rekam-medis*') || Request::is('tambah-rekam-medis-dokter*') ? 'active' : '' }}" href="/lihat-rekam-medis">
            <i class="fa-solid fa-file-medical"></i>
            <span>Rekam Medis</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    {{-- LAINNYA --}}
    <div class="sidebar-heading">
        Lainnya
    </div>

    <li class="nav-item">
        <a class="nav-link" href="/">
            <i class="fa-solid fa-house"></i>
            <span>Halaman Depan</span>
        </a>
    </li>

    {{-- TOMBOL TOGGLE (Panah Kiri/Kanan) --}}
    <div class="text-center d-none d-md-inline mt-4">
        <button class="rounded-circle border-0" id="sidebarToggle" style="background-color: rgba(255,255,255,0.2); color: white;"></button>
    </div>

</ul>