<style>
    /* Gradient Royal Blue untuk Sidebar */
    .bg-gradient-royal-sidebar {
        background: linear-gradient(180deg, #af531eff 0%, #2563eb 100%);
        background-size: cover;
    }
    
    /* RESET STYLE SIDEBAR */
    #accordionSidebar .nav-item { 
        margin-bottom: 5px; 
        padding: 0 10px; 
    }
    
    #accordionSidebar .nav-item .nav-link {
        border-radius: 8px;
        color: rgba(255, 255, 255, 0.85) !important;
        font-weight: 500;
        width: 100%;
        
        /* FLEXBOX UNTUK JARAK */
        display: flex !important; 
        align-items: center !important;
        gap: 15px !important; /* Jarak modern antar elemen flex */
        
        transition: all 0.2s;
        padding: 0.8rem 1rem;
    }
    
    #accordionSidebar .nav-item .nav-link:hover, 
    #accordionSidebar .nav-item .nav-link.active {
        background-color: rgba(255, 255, 255, 0.2);
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* PAKSA JARAK ICON DENGAN MARGIN EXTRA */
    #accordionSidebar .nav-item .nav-link i { 
        margin-right: 10px !important; /* Tambahan margin kanan */
        width: 25px !important;        /* Lebar fix agar icon sejajar vertikal */
        text-align: center; 
        font-size: 1rem;
    }
    
    #accordionSidebar .nav-item .nav-link span {
        font-size: 0.9rem;
    }

    #accordionSidebar .sidebar-brand { background-color: rgba(0, 0, 0, 0.1); }
</style>

<ul class="navbar-nav bg-gradient-royal-sidebar sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- BRAND --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center my-3" href="/dashboard-staff">
        <div class="sidebar-brand-icon">
            <img src="/img/logo.png" alt="" width="45" style="filter: drop-shadow(0 2px 2px rgba(0,0,0,0.2));">
        </div>
        <div class="sidebar-brand-text mx-3">STAFF</div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- DASHBOARD --}}
    <li class="nav-item">
        <a class="nav-link {{ Request::is('dashboard-staff') ? 'active' : '' }}" href="/dashboard-staff">
            <i class="fa-solid fa-gauge-high"></i>
            <span>Dashboard</span>
        </a>
    </li>

    {{-- KELOLA JADWAL --}}
    <li class="nav-item">
        <a class="nav-link {{ Request::is('kelola-jadwal*') ? 'active' : '' }}" href="/kelola-jadwal">
            <i class="fa-solid fa-calendar-days"></i>
            <span>Kelola Jadwal</span>
        </a>
    </li>

    {{-- KELOLA PASIEN --}}
    <li class="nav-item">
        <a class="nav-link {{ Request::is('kelola-pasien*') ? 'active' : '' }}" href="/kelola-pasien">
            <i class="fa-solid fa-users"></i>
            <span>Kelola Pasien</span>
        </a>
    </li>

    {{-- KELOLA RESERVASI --}}
    <li class="nav-item">
        <a class="nav-link {{ Request::is('kelola-reservasi*') ? 'active' : '' }}" href="/kelola-reservasi">
            <i class="fa-solid fa-list-check"></i>
            <span>Kelola Reservasi</span>
        </a>
    </li>

    {{-- KELOLA REKAM MEDIS --}}
    <li class="nav-item">
        <a class="nav-link {{ Request::is('kelola-rekam-medis*') ? 'active' : '' }}" href="/kelola-rekam-medis">
            <i class="fa-solid fa-file-medical"></i>
            <span>Kelola Rekam Medis</span>
        </a>
    </li>

    <hr class="sidebar-divider">

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