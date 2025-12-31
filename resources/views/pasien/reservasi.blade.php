@extends('maintemplatedashboard')

@section('content')

{{-- CSS Custom --}}
<style>
    :root {
        --indigo-primary: #4e73df;
        --indigo-light: #764ba2;
        --indigo-soft: #e7f1ff;
    }

    /* Fix Masalah Dropdown: Pastikan wrapper tidak memotong konten */
    #wrapper {
        overflow: visible !important; 
    }

    /* Tabel Styling */
    .table thead th {
        background-color: var(--indigo-soft);
        color: var(--indigo-primary);
        border-bottom: 2px solid var(--indigo-primary);
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        vertical-align: middle;
    }
    .table tbody td {
        vertical-align: middle;
    }
    .table tbody tr:hover {
        background-color: rgba(78, 115, 223, 0.05);
    }

    /* Form & Pagination */
    .form-control:focus {
        border-color: var(--indigo-primary);
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }
    .page-item.active .page-link {
        background-color: var(--indigo-primary);
        border-color: var(--indigo-primary);
    }
    .page-link { color: var(--indigo-primary); }
</style>

{{-- HAPUS class 'overflow-hidden' di sini agar dropdown bisa muncul --}}
<div id="wrapper" class="d-flex w-100">

    {{-- 1. SIDEBAR PASIEN --}}
    @include('partials.sidebar')

    {{-- 2. CONTENT WRAPPER --}}
    <div id="content-wrapper" class="d-flex flex-column w-100 min-vh-100 bg-light position-relative">
        
        {{-- TOPBAR (Tambahkan z-index tinggi) --}}
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm px-4" style="z-index: 1050;">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
                <i class="fa fa-bars text-indigo"></i>
            </button>
            <h5 class="d-none d-sm-block m-0 fw-bold text-secondary">Riwayat Reservasi</h5>
            
            <ul class="navbar-nav ms-auto">
                <div class="topbar-divider d-none d-sm-block"></div>
                
                {{-- PROFIL USER --}}
                <li class="nav-item dropdown no-arrow">
                    {{-- Tambahkan data-toggle (BS4) DAN data-bs-toggle (BS5) untuk jaga-jaga --}}
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
                       data-bs-toggle="dropdown" data-toggle="dropdown" 
                       aria-haspopup="true" aria-expanded="false">
                        
                        <span class="me-2 d-none d-lg-inline text-gray-600 small fw-bold">
                            {{ strtoupper(auth()->user()->name) }}
                        </span>
                        @if(auth()->user()->image != null)
                            <img class="img-profile rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #4e73df;" src="{{asset('/images/'.auth()->user()->image)}}">
                        @else
                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; font-weight: bold; background-color: #4e73df;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </a>
                    
                    {{-- DROPDOWN MENU --}}
                    <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in border-0" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="/profile">
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

                {{-- NOTIFIKASI --}}
                @if(session()->has('salah'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('salah')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session()->has('Success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fa-solid fa-check-circle me-2"></i> {{ session('Success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- CARD TABLE --}}
                <div class="card border-0 shadow-sm rounded-4 mb-5">
                    <div class="card-header bg-white py-4 rounded-top-4">
                        <div class="row g-3 align-items-center justify-content-between">
                            <div class="col-12 col-md-6">
                                <h6 class="m-0 fw-bold" style="color: #4e73df;">
                                    <i class="fa-solid fa-list-check me-2"></i> Daftar Reservasi Saya
                                </h6>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </span>
                                    <input type="search" id="search" class="form-control bg-light border-start-0 small" placeholder="Cari tanggal atau keluhan..." aria-label="Search">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center" width="5%">No</th>
                                        <th>Nama Pasien</th>
                                        <th class="text-center">Tanggal Reservasi</th>
                                        <th>Keluhan</th>
                                        <th class="text-center">No. Antrian</th>
                                        <th class="text-center">Status Kehadiran</th>
                                    </tr>
                                </thead>
                                
                                <tbody id="alldata">
                                    @foreach ($reservasi as $index => $item)
                                    <tr>
                                        <td class="text-center fw-bold text-secondary">
                                            {{ $reservasi->firstItem() + $index }}
                                        </td>
                                        <td class="fw-bold text-dark">
                                            {{ $item->nama_pasien }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border">
                                                {{ date('d M Y', strtotime($item->tgl_reservasi)) }}
                                            </span>
                                        </td>
                                        <td class="small text-muted">
                                            {{ Str::limit($item->keluhan, 50) }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 30px; height: 30px; background-color: #4e73df !important;">
                                                {{ $item->no_antrian }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($item->status_hadir == 0)
                                                <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                                    <i class="fa-regular fa-clock me-1"></i> Belum Hadir
                                                </span>
                                            @elseif ($item->status_hadir == 1)
                                                <span class="badge rounded-pill bg-success px-3 py-2">
                                                    <i class="fa-solid fa-check me-1"></i> Hadir
                                                </span>
                                            @elseif ($item->status_hadir == 2)
                                                <span class="badge rounded-pill bg-danger px-3 py-2">
                                                    <i class="fa-solid fa-xmark me-1"></i> Tidak Hadir
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                    @if($reservasi->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fa-solid fa-box-open fa-3x mb-3 opacity-50"></i><br>
                                                Belum ada riwayat reservasi.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tbody id="konten"></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer bg-white py-3 rounded-bottom-4">
                        <div class="d-flex justify-content-end">
                             {{ $reservasi->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#search').on('keyup', function () {
            var value = $(this).val();
            if(value){ $('#alldata').hide(); $('.card-footer').hide(); } 
            else { $('#alldata').show(); $('.card-footer').show(); }
            
            $.ajax({
                type: 'get',
                url: '{{ URL::to('cari-reservasi-pasien') }}',
                data: {'data': value},
                success: function(data){ $('#konten').html(data); }
            });
        });
    });
</script>

@endsection