<style>
    /* Gradient Indigo Modern */
    .bg-gradient-indigo-sidebar {
        background: linear-gradient(180deg, #4e73df 0%, #224abe 100%);
        background-size: cover;
    }

    /* 1. RESET STYLE SIDEBAR PASIEN DENGAN ID SELECTOR */
    #accordionSidebar .nav-item {
        margin-bottom: 5px;
        padding: 0 12px;
    }

    #accordionSidebar .nav-item .nav-link {
        border-radius: 8px;
        transition: all 0.2s ease;
        padding: 0.8rem 1rem;
        color: rgba(255, 255, 255, 0.85) !important;
        font-weight: 500;
        width: 100%;
        
        /* FLEXBOX UNTUK JARAK YANG KUAT */
        display: flex !important;
        align-items: center !important;
        gap: 15px !important; /* Jarak modern antar elemen */
    }

    /* 2. Efek Hover */
    #accordionSidebar .nav-item .nav-link:hover, 
    #accordionSidebar .nav-item .nav-link.active {
        background-color: rgba(255, 255, 255, 0.2);
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* 3. PENGATURAN ICON - PAKSA JARAK */
    #accordionSidebar .nav-item .nav-link i {
        font-size: 1rem;
        margin-right: 10px !important; /* Tambahan margin kanan */
        width: 25px !important;        /* Lebar fix agar icon sejajar */
        text-align: center;
        color: rgba(255, 255, 255, 0.75);
    }
    
    #accordionSidebar .nav-item .nav-link:hover i {
        color: #ffffff;
    }
    
    #accordionSidebar .nav-item .nav-link span {
        font-size: 0.9rem;
    }

    #accordionSidebar .sidebar-divider {
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        margin: 1rem 0;
    }

    #accordionSidebar .sidebar-brand {
        background-color: rgba(0, 0, 0, 0.1);
    }

    #accordionSidebar .sidebar-heading {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255, 255, 255, 0.6);
        padding: 0 1.5rem;
        margin-top: 1.5rem;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }
</style>

<ul class="navbar-nav bg-gradient-indigo-sidebar sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center my-3" href="/dashboard">
        <div class="sidebar-brand-icon">
             <img src="/img/logo.png" alt="" width="45" style="filter: drop-shadow(0 2px 2px rgba(0,0,0,0.2));">
        </div>
        <div class="sidebar-brand-text mx-3">PASIEN</div>
    </a>

    <hr class="sidebar-divider my-0">

    <div class="sidebar-heading">Menu Utama</div>

    <li class="nav-item">
        <a class="nav-link" href="/dashboard">
            <i class="fa-solid fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/reservasi">
            <i class="fa-solid fa-calendar-check"></i>
            <span>Reservasi</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="/rekam-medis">
            <i class="fa-solid fa-file-medical"></i>
            <span>Riwayat Pemeriksaan</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Lainnya</div>

    <li class="nav-item">
        <a class="nav-link" href="/">
            <i class="fa-solid fa-house"></i>
            <span>Halaman Depan</span>
        </a>
    </li>

    <div class="text-center d-none d-md-inline mt-4">
        <button class="rounded-circle border-0" id="sidebarToggle" style="background-color: rgba(255,255,255,0.2); color: white;"></button>
    </div>

</ul>