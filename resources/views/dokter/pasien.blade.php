@extends('maintemplatedashboard')

@section('content')

{{-- CSS Custom untuk Halaman Ini --}}
<style>
    :root {
        --medical-primary: #0f766e;
        --medical-light: #14b8a6;
        --medical-soft: #ccfbf1;
    }
    
    /* Tabel Styling */
    .table thead th {
        background-color: var(--medical-soft);
        color: var(--medical-primary);
        border-bottom: 2px solid var(--medical-primary);
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
    }
    .table tbody tr:hover {
        background-color: rgba(20, 184, 166, 0.05);
    }
    
    /* Pagination Color Override */
    .page-item.active .page-link {
        background-color: var(--medical-primary);
        border-color: var(--medical-primary);
    }
    .page-link { color: var(--medical-primary); }

    /* Search Input Focus */
    .form-control:focus {
        border-color: var(--medical-primary);
        box-shadow: 0 0 0 0.25rem rgba(15, 118, 110, 0.25);
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

            <h5 class="d-none d-sm-block m-0 fw-bold text-secondary">Data Pasien</h5>

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

                {{-- Alert Success --}}
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fa-solid fa-check-circle me-2"></i> {{ session('success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- CARD TABLE --}}
                <div class="card border-0 shadow-sm rounded-4 mb-5">
                    
                    {{-- Card Header: Judul & Search --}}
                    <div class="card-header bg-white py-3 d-flex flex-column flex-md-row align-items-center justify-content-between rounded-top-4">
                        <h6 class="m-0 fw-bold" style="color: #0f766e;">
                            <i class="fa-solid fa-users-medical me-2"></i> Daftar Seluruh Pasien
                        </h6>
                        
                        {{-- Search Input Unified --}}
                        <div class="mt-3 mt-md-0 w-100 w-md-auto">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-pill">
                                    <i class="fas fa-search text-gray-400"></i>
                                </span>
                                <input type="search" id="search" class="form-control bg-light border-start-0 small rounded-end-pill" placeholder="Cari nama pasien..." aria-label="Search">
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center py-3" width="5%">No</th>
                                        <th class="py-3">Nama Pasien</th>
                                        <th class="text-center py-3">Tanggal Lahir</th>
                                        <th class="py-3">Alamat</th>
                                        <th class="py-3">Email</th>
                                        <th class="text-center py-3">No. Telp</th>
                                    </tr>
                                </thead>
                                <tbody id="old">
                                    @php $j = 0; @endphp
                                    @foreach ($user as $index => $item)
                                    @php $j++; @endphp
                                    <tr>
                                        <td class="text-center fw-bold text-secondary">{{ $user->firstItem() + $index }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                                    <i class="fa-solid fa-user text-secondary"></i>
                                                </div>
                                                <span class="fw-bold text-dark">{{ $item->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border">
                                                {{ date('d M Y', strtotime($item->birthday))}}
                                            </span>
                                        </td>
                                        <td class="small">{{ Str::limit($item->address, 30) }}</td>
                                        <td class="small text-primary">{{ $item->email }}</td>
                                        <td class="text-center">
                                            <a href="https://wa.me/{{ $item->telp }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3">
                                                <i class="fab fa-whatsapp me-1"></i> {{ $item->telp }}
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach

                                    @if($user->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fa-solid fa-folder-open fa-3x mb-3 opacity-50"></i><br>
                                                Belum ada data pasien.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tbody id="new"></tbody>
                            </table>
                        </div>
                    </div>
                    
                    {{-- Pagination Footer --}}
                    <div class="card-footer bg-white py-3 rounded-bottom-4">
                        <div class="d-flex justify-content-end">
                            {{ $user->links() }} 
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- FOOTER --}}
        <footer class="bg-white py-3 mt-auto border-top">
            <div class="container-fluid">
                <div class="text-center text-muted small">
                    <span>&copy; {{ date('Y') }} Kelompok 12 SI UA - Dashboard dr. Em</span>
                </div>
            </div>
        </footer>

    </div>
</div>

{{-- SCRIPT AJAX SEARCH --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#search').on('keyup', function () {
            var value = $(this).val();
            
            if(value) {
                $('#old').hide();
                $('.card-footer').hide(); // Sembunyikan pagination saat search
            } else {
                $('#old').show();
                $('.card-footer').show();
            }

            $.ajax({
                type: 'get',
                url: '{{ URL::to('cari-pasien-dokter') }}',
                data: {'data': value},
                success: function(data) {
                    $('#new').html(data);
                }
            });
        });
    });
</script>

@endsection