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
    
    /* Tombol & Input */
    .btn-medical {
        background-color: var(--medical-primary);
        color: white;
    }
    .btn-medical:hover {
        background-color: #0d5f5a;
        color: white;
    }
    .form-select:focus, .form-control:focus {
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
            <h5 class="d-none d-sm-block m-0 fw-bold text-secondary">Jadwal Praktek</h5>
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
                    
                    {{-- HEADER: Filter & Judul --}}
                    <div class="card-header bg-white py-4">
                        <div class="row g-3 align-items-center justify-content-between">
                            
                            {{-- Judul --}}
                            <div class="col-12 col-md-4">
                                <h6 class="m-0 fw-bold text-primary" style="color: #0f766e !important;">
                                    <i class="fa-solid fa-calendar-days me-2"></i> Daftar Jadwal Saya
                                </h6>
                            </div>

                            {{-- Form Filter --}}
                            <div class="col-12 col-md-8">
                                <form action="/lihat-jadwal" method="post">
                                    @csrf
                                    <div class="row g-2 justify-content-md-end">
                                        {{-- Filter Bulan --}}
                                        <div class="col-6 col-md-4">
                                            <select name="filter" class="form-select form-select-sm bg-light border-0">
                                                <option value="">-- Pilih Bulan --</option>
                                                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $key => $bulan)
                                                    <option value="{{ $key+1 }}">{{ $bulan }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Filter Tahun --}}
                                        <div class="col-4 col-md-3">
                                            <select name="year" class="form-select form-select-sm bg-light border-0">
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                                            </select>
                                        </div>

                                        {{-- Tombol Filter --}}
                                        <div class="col-2 col-md-2">
                                            <button type="submit" class="btn btn-medical btn-sm w-100 shadow-sm">
                                                <i class="bi bi-filter"></i> Filter
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Baris Search (Ajax) Terpisah agar rapi --}}
                        <div class="row mt-3">
                             <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </span>
                                    <input type="search" id="search" class="form-control border-start-0 ps-0" placeholder="Cari jadwal berdasarkan tanggal..." aria-label="Search">
                                </div>
                             </div>
                        </div>
                    </div>

                    {{-- BODY: Tabel --}}
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center" width="5%">No</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Jam Praktek</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Kuota Pasien</th>
                                    </tr>
                                </thead>
                                
                                <tbody id="old">
                                    @php $no = 0; @endphp
                                    @foreach ($jadwal as $item)
                                    @php $no++ @endphp
                                    <tr>
                                        <td class="text-center fw-bold text-secondary">{{ $jadwal->firstItem() + $loop->index }}</td>
                                        
                                        {{-- Tanggal --}}
                                        <td class="text-center fw-bold text-dark">
                                            {{ date('d M Y', strtotime($item->tgl_jadwal)) }}
                                        </td>
                                        
                                        {{-- Jam --}}
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border">
                                                {{ $item->jam_masuk }} - {{ $item->jam_pulang }}
                                            </span>
                                        </td>

                                        {{-- Status (Badge) --}}
                                        <td class="text-center">
                                            @if ($item->status_masuk == 1)
                                                <span class="badge rounded-pill bg-success px-3 py-2">
                                                    <i class="fa-solid fa-check-circle me-1"></i> Hadir
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-secondary px-3 py-2">
                                                    <i class="fa-solid fa-xmark-circle me-1"></i> Tidak Hadir
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Kuota --}}
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <i class="fa-solid fa-users me-2 text-info"></i>
                                                <span class="fw-bold">{{ $item->jumlah_maxpasien }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                    @if($jadwal->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="fa-solid fa-calendar-xmark fa-3x mb-3 opacity-50"></i><br>
                                                Tidak ada jadwal ditemukan.
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
                             {{ $jadwal->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Search Logic
        $('#search').on('keyup', function () {
            var value = $(this).val();
            
            if(value){
                $('#old').hide();
                $('.card-footer').hide(); // Sembunyikan pagination saat search
            } else {
                $('#old').show();
                $('.card-footer').show();
            }

            $.ajax({
                type: 'get',
                url: '{{ URL::to('cari-jadwal-dokter')}}',
                data: {'cari-jadwal': value},
                success: function(data){
                    $('#new').html(data);
                }
            });
        });
    });
</script>

@endsection