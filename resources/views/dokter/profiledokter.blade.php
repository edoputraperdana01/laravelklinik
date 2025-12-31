@extends('maintemplatedashboard')

@section('content')

{{-- CSS Custom (Tema Medis) --}}
<style>
    :root {
        --medical-primary: #0f766e;
        --medical-light: #14b8a6;
        --medical-soft: #ccfbf1;
    }

    /* Card Styling */
    .card-profile-header {
        background: linear-gradient(135deg, var(--medical-primary) 0%, var(--medical-light) 100%);
        height: 120px;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }
    
    .profile-avatar-container {
        margin-top: -75px;
        display: flex;
        justify-content: center;
    }

    .avatar-img {
        width: 150px;
        height: 150px;
        border: 5px solid #fff;
        object-fit: cover;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
    }

    .avatar-initial {
        width: 150px;
        height: 150px;
        border: 5px solid #fff;
        background-color: var(--medical-primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: bold;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
    }

    /* Form & Buttons */
    .form-control:focus {
        border-color: var(--medical-primary);
        box-shadow: 0 0 0 0.25rem rgba(15, 118, 110, 0.25);
    }

    .btn-medical {
        background-color: var(--medical-primary);
        color: white;
        border: none;
    }
    .btn-medical:hover {
        background-color: #0d5f5a;
        color: white;
    }

    .btn-outline-medical {
        border: 1px solid var(--medical-primary);
        color: var(--medical-primary);
        background: transparent;
    }
    .btn-outline-medical:hover {
        background-color: var(--medical-primary);
        color: white;
    }
</style>

<div id="wrapper" class="d-flex w-100 overflow-hidden">

    {{-- 1. SIDEBAR --}}
    @include('partials.sidebardokter')

    {{-- 2. CONTENT WRAPPER --}}
    <div id="content-wrapper" class="d-flex flex-column w-100 min-vh-100 bg-light position-relative">
        
        {{-- TOPBAR --}}
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm px-4">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
                <i class="fa fa-bars" style="color: #0f766e;"></i>
            </button>
            <h5 class="d-none d-sm-block m-0 fw-bold text-secondary">Pengaturan Akun</h5>
            <ul class="navbar-nav ms-auto">
                <div class="topbar-divider d-none d-sm-block"></div>
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="me-2 d-none d-lg-inline text-gray-600 small fw-bold">
                            {{ strtoupper(auth()->user()->name) }}
                        </span>
                        @if(auth()->user()->image != null)
                            <img class="img-profile rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #0f766e;" src="{{asset('/images/'.auth()->user()->image)}}">
                        @else
                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; font-weight: bold; background-color: #0f766e;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in border-0" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="/profile-dokter">
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

                {{-- ALERTS --}}
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fa-solid fa-check-circle me-2"></i> {{ session('success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session()->has('fail'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('fail')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                    
                    {{-- KOLOM KIRI: FOTO PROFIL --}}
                    <div class="col-lg-4 mb-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100">
                            {{-- Header Gradasi --}}
                            <div class="card-profile-header"></div>
                            
                            <div class="card-body text-center pt-0">
                                {{-- Avatar --}}
                                <div class="profile-avatar-container mb-3">
                                    @if(Auth::user()->image != null)
                                        <img class="rounded-circle avatar-img" src="{{asset('/images/'.Auth::user()->image)}}" alt="Profile">
                                    @else
                                        <div class="rounded-circle avatar-initial">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>

                                <h5 class="fw-bold text-dark mb-1">{{ Auth::user()->name }}</h5>
                                <p class="text-muted mb-4"><i class="fa-solid fa-user-doctor me-1"></i> Dokter Spesialis</p>

                                {{-- Tombol Upload & Hapus --}}
                                <div class="d-grid gap-2 col-10 mx-auto">
                                    <form action="/upload-foto-dokter" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="image" id="image" class="d-none" onchange="this.form.submit()">
                                        <label for="image" class="btn btn-medical w-100 shadow-sm" style="cursor: pointer;">
                                            <i class="fa-solid fa-camera me-2"></i> Ganti Foto
                                        </label>
                                    </form>
                                    
                                    @if(Auth::user()->image != null)
                                        <button type="button" class="btn btn-outline-danger shadow-sm" id="buttonHapus">
                                            <i class="fa-solid fa-trash me-2"></i> Hapus Foto
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: FORM EDIT --}}
                    <div class="col-lg-8 mb-4">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white py-3 rounded-top-4 border-bottom">
                                <h6 class="m-0 fw-bold" style="color: #0f766e;">
                                    <i class="fa-solid fa-user-gear me-2"></i> Edit Informasi Akun
                                </h6>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="/profile-dokter" autocomplete="off">
                                    @csrf

                                    <h6 class="heading-small text-muted mb-4 text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Informasi Pribadi</h6>
                                    
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Nama Lengkap</label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Tanggal Lahir</label>
                                            <input type="date" name="birthday" class="form-control" value="{{ old('birthday', Auth::user()->birthday) }}">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label small fw-bold">Alamat</label>
                                            <input type="text" name="address" class="form-control" value="{{ old('address', Auth::user()->address) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">No. Handphone</label>
                                            <input type="number" name="telp" class="form-control" value="{{ old('telp', Auth::user()->telp) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Email</label>
                                            <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}">
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <h6 class="heading-small text-muted mb-4 text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Keamanan (Ganti Password)</h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Password Saat Ini</label>
                                            <input type="password" name="current_password" class="form-control" placeholder="********">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Password Baru</label>
                                            <input type="password" name="new_password" class="form-control" placeholder="********">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="********">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="submit" class="btn btn-medical px-4 py-2 shadow-sm">
                                            <i class="fa-solid fa-save me-2"></i> Simpan Perubahan
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

{{-- MODAL HAPUS FOTO --}}
<div class="modal fade" id="hapusFoto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white closemodal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fa-solid fa-image fa-3x text-danger mb-3"></i>
                <p class="mb-0">Apakah Anda yakin ingin menghapus foto profil?</p>
            </div>
            <div class="modal-footer justify-content-center bg-light">
                <button class="btn btn-secondary px-4 closemodal" type="button" data-bs-dismiss="modal">Batal</button>
                <form action="/hapus-foto" method="POST">
                    @csrf
                    <button class="btn btn-danger px-4" type="submit">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#buttonHapus').click(function (e) {
            e.preventDefault();
            $('#hapusFoto').modal('show');
        });
        
        // Support untuk tombol close bootstrap 5 & 4
        $('.closemodal, .btn-close').click(function (e) {
            $('#hapusFoto').modal('hide');
        });
    });
</script>

@endsection