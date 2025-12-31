@extends('maintemplatedashboard')

@section('content')

{{-- CSS Custom (Tema Medis) --}}
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
        text-transform: uppercase;
        font-size: 0.85rem;
        vertical-align: middle;
    }
    .table tbody td {
        vertical-align: middle;
    }
    .table tbody tr:hover {
        background-color: rgba(20, 184, 166, 0.05);
    }

    /* Form Elements */
    .form-control:focus {
        border-color: var(--medical-primary);
        box-shadow: 0 0 0 0.25rem rgba(15, 118, 110, 0.25);
    }
    .btn-medical {
        background-color: var(--medical-primary);
        color: white;
    }
    .btn-medical:hover {
        background-color: #0d5f5a;
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
            <h5 class="d-none d-sm-block m-0 fw-bold text-secondary">Reservasi Pasien</h5>
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

                <div class="card border-0 shadow-sm rounded-4 mb-5">
                    
                    {{-- HEADER: Filter Tanggal & Search --}}
                    <div class="card-header bg-white py-4 rounded-top-4">
                        <div class="row g-3 align-items-center justify-content-between">
                            
                            {{-- Judul --}}
                            <div class="col-12 col-lg-4">
                                <h6 class="m-0 fw-bold" style="color: #0f766e;">
                                    <i class="fa-solid fa-clipboard-list me-2"></i> Daftar Reservasi
                                </h6>
                            </div>

                            {{-- Filter & Search Area --}}
                            <div class="col-12 col-lg-8">
                                <div class="row g-2 justify-content-lg-end">
                                    
                                    {{-- Form Filter Tanggal --}}
                                    <div class="col-12 col-md-6">
                                        <form action="/lihat-reservasi" method="post">
                                            @csrf
                                            <div class="input-group">
                                                <input type="date" name="tanggal" class="form-control bg-light border-0 small" value="{{ request('tanggal') }}">
                                                <button type="submit" class="btn btn-medical shadow-sm">
                                                    <i class="bi bi-calendar-check me-1"></i> Filter
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Input Search (Ajax) --}}
                                    <div class="col-12 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-search text-gray-400"></i>
                                            </span>
                                            <input type="search" id="search" class="form-control bg-light border-start-0 small" placeholder="Cari nama pasien..." aria-label="Search">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TABLE BODY --}}
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center" width="5%">No</th>
                                        <th>Nama Pasien</th>
                                        <th class="text-center">Tgl. Reservasi</th>
                                        <th>Keluhan</th>
                                        <th class="text-center">No. Antrian</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                
                                <tbody id="old">
                                    @foreach($reservasi as $index => $item)
                                    <tr>
                                        <td class="text-center fw-bold text-secondary">
                                            {{ $reservasi->firstItem() + $index }}
                                        </td>
                                        <td class="fw-bold text-dark">
                                            {{ $item->nama_pasien }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border">
                                                {{ date('d-m-Y', strtotime($item->tgl_reservasi)) }}
                                            </span>
                                            <br>
                                            <small class="text-muted">{{ date('D', strtotime($item->tgl_reservasi)) }}</small>
                                        </td>
                                        <td>
                                            <span class="text-muted small">{{ Str::limit($item->keluhan, 40) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 14px;">
                                                {{ $item->no_antrian }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($item->status_hadir == 0)
                                                <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                                    <i class="fa-solid fa-clock me-1"></i> Belum Hadir
                                                </span>
                                            @elseif($item->status_hadir == 1)
                                                <span class="badge rounded-pill bg-success px-3 py-2">
                                                    <i class="fa-solid fa-check-circle me-1"></i> Hadir
                                                </span>
                                            @elseif($item->status_hadir == 2)
                                                <span class="badge rounded-pill bg-secondary px-3 py-2">
                                                    <i class="fa-solid fa-xmark-circle me-1"></i> Tidak Hadir
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                    @if($reservasi->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fa-solid fa-clipboard-question fa-3x mb-3 opacity-50"></i><br>
                                                Tidak ada data reservasi ditemukan.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>

                                <tbody id="new"></tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Footer Pagination --}}
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

{{-- SCRIPT AJAX SEARCH --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#search').on('keyup', function () {
            var value = $(this).val();
            
            if(value){
                $('#old').hide();
                $('.card-footer').hide(); 
            } else {
                $('#old').show();
                $('.card-footer').show();
            }

            $.ajax({
                type: 'get',
                url: '{{ URL::to('cari-reservasi-dokter') }}',
                data: {'data': value},
                success: function(data){
                    $('#new').html(data);
                }
            });
        });
    });
</script>

@endsection