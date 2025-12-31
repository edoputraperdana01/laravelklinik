@extends('maintemplatedashboard')

@section('content')

{{-- CSS Custom --}}
<style>
    :root {
        --royal-blue: #2563eb;
        --royal-dark: #1e40af;
        --royal-soft: #eff6ff;
    }
    .table thead th {
        background-color: var(--royal-soft);
        color: var(--royal-blue);
        border-bottom: 2px solid var(--royal-blue);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        vertical-align: middle;
    }
    .page-item.active .page-link { background-color: var(--royal-blue); border-color: var(--royal-blue); }
    .page-link { color: var(--royal-blue); }
</style>

<div id="wrapper" class="d-flex w-100 overflow-hidden">

    {{-- SIDEBAR STAFF (Wajib pakai include) --}}
    @include('partials.sidebarstaff')

    {{-- CONTENT WRAPPER --}}
    <div id="content-wrapper" class="d-flex flex-column w-100 min-vh-100 bg-light position-relative">
        
        {{-- TOPBAR --}}
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm px-4">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3"><i class="fa fa-bars text-royal"></i></button>
            <h5 class="d-none d-sm-block m-0 fw-bold text-secondary">Kelola Reservasi</h5>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <span class="me-2 d-none d-lg-inline text-gray-600 small fw-bold">{{ strtoupper(auth()->user()->name) }}</span>
                        @if(auth()->user()->image != null)
                            <img class="img-profile rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #2563eb;" src="{{asset('/images/'.auth()->user()->image)}}">
                        @else
                            <div class="rounded-circle bg-royal text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; font-weight: bold; background-color: var(--royal-blue);">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in border-0" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="/profile-staff">
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

                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4">
                    <i class="fa-solid fa-check-circle me-2"></i> {{ session('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4 mb-5">
                    
                    {{-- HEADER & FILTER --}}
                    <div class="card-header bg-white py-4 rounded-top-4">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-12 col-md-4 mb-3 mb-md-0">
                                <h6 class="m-0 fw-bold" style="color: var(--royal-blue);">
                                    <i class="fa-solid fa-list-check me-2"></i> Daftar Reservasi
                                </h6>
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="d-flex gap-2 justify-content-md-end">
                                    {{-- Filter Tanggal --}}
                                    <form action="/kelola-reservasi" method="post" class="d-flex">
                                        @csrf
                                        <div class="input-group">
                                            <input type="date" name="tanggal" class="form-control border-end-0" value="{{ request('tanggal') ?? date('Y-m-d') }}">
                                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-filter"></i> Filter</button>
                                        </div>
                                    </form>
                                    {{-- Search --}}
                                    <div class="input-group" style="max-width: 250px;">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-gray-400"></i></span>
                                        <input type="search" id="search" class="form-control bg-light border-start-0" placeholder="Cari..." aria-label="Search">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TABLE --}}
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" width="100%" cellspacing="0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center" width="5%">No</th>
                                        <th>Nama Pasien</th>
                                        <th class="text-center">Tanggal</th>
                                        <th>Keluhan</th>
                                        <th class="text-center">Antrian</th>
                                        <th class="text-center" width="25%">Update Status</th>
                                    </tr>
                                </thead>
                                <tbody id="old">
                                    @foreach($reservasi as $index => $item)
                                    <tr>
                                        <td class="align-middle text-center fw-bold text-secondary">{{ $reservasi->firstItem() + $index }}</td>
                                        <td class="align-middle fw-bold">{{ $item->nama_pasien }}</td>
                                        <td class="align-middle text-center">{{ date('d M Y', strtotime($item->tgl_reservasi)) }}</td>
                                        <td class="align-middle small text-muted">{{ Str::limit($item->keluhan, 30) }}</td>
                                        <td class="align-middle text-center"><span class="badge rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width:30px; height:30px;">{{ $item->no_antrian }}</span></td>
                                        <td class="align-middle text-center">
                                            <form action="edit-reservasi" method="post" class="d-flex gap-1 justify-content-center align-items-center">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id_reservasi }}">
                                                <input type="hidden" name="tgl" value="{{ $item->tgl_reservasi }}">
                                                
                                                <select name="status" class="form-select form-select-sm" style="width: 130px;">
                                                    <option value="0" {{ $item->status_hadir == 0 ? 'selected' : '' }}>Belum Hadir</option>
                                                    <option value="1" {{ $item->status_hadir == 1 ? 'selected' : '' }}>Hadir</option>
                                                    <option value="2" {{ $item->status_hadir == 2 ? 'selected' : '' }}>Tidak Hadir</option>
                                                </select>
                                                <button title="Simpan" type="submit" class="btn btn-sm btn-primary"><i class="fa-solid fa-floppy-disk"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tbody id="new"></tbody>
                            </table>
                        </div>
                    </div>

                    {{-- PAGINATION --}}
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

{{-- SCRIPT AJAX --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#search').on('keyup',function () {
           var value = $(this).val();
           if(value){ $('#old').hide(); $('.card-footer').hide(); }
           else{ $('#old').show(); $('.card-footer').show(); }
           
           $.ajax({
            type:'get',
            url:'{{ URL::to('cari-reservasi')}}',
            data:{'data': value},
            success:function(data){ $('#new').html(data); }
           });
        })
    });
</script>

@endsection