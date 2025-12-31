<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
  <div class="container">
    
    <a class="navbar-brand d-flex align-items-center" href="/">
      <img src="/img/logo.png" alt="" width="45" height="auto" class="me-2">
      <span class="fw-bold text-dark" style="letter-spacing: 1px;">SEHATIN</span>
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/#cekjadwal">Reservasi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/#tentangkami">Tentang Kami</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/#hubungikami">Hubungi Kami</a>
        </li>
      </ul>

      <div class="d-flex align-items-center">
        @auth
            @php
                $dashboardUrl = '/dashboard'; // Default (Level 0/User)
                if(auth()->user()->level == 1) $dashboardUrl = '/dashboard-staff';
                if(auth()->user()->level == 2) $dashboardUrl = '/dashboard-dokter';
            @endphp

            <div class="dropdown">
                <a class="nav-link dropdown-toggle text-dark fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle text-primary me-1"></i>
                    {{ strtoupper(auth()->user()->name) }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <li>
                        <a class="dropdown-item py-2" href="{{ $dashboardUrl }}">
                            <i class="bi bi-speedometer2 me-2 text-secondary"></i>Dashboard
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="/logout" method="post" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        @else
            <a href="/login" class="btn btn-outline-primary btn-nav me-2">Login</a>
            <a href="/register" class="btn btn-primary btn-nav">Register</a>
        @endauth
      </div>

    </div>
  </div>
</nav>