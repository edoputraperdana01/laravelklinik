@extends('maintemplatedashboard')

@section('content')

{{-- CSS Custom (Tema Staff - Royal Blue) --}}
<style>
    :root {
        --royal-blue: #2563eb;
        --royal-dark: #1e40af;
        --royal-soft: #eff6ff;
        --royal-gold: #f59e0b;
    }

    /* Tabel Styling */
    .table thead th {
        background-color: var(--royal-soft);
        color: var(--royal-blue);
        border-bottom: 2px solid var(--royal-blue);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        vertical-align: middle;
    }
    .table tbody td {
        vertical-align: middle;
    }
    .table tbody tr:hover {
        background-color: rgba(37, 99, 235, 0.05);
    }

    /* Pagination & Form */
    .page-item.active .page-link {
        background-color: var(--royal-blue);
        border-color: var(--royal-blue);
    }
    .page-link { color: var(--royal-blue); }
    .form-control:focus { border-color: var(--royal-blue); box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25); }
</style>

<div id="wrapper" class="d-flex w-100 overflow-hidden">

    {{-- 1. SIDEBAR STAFF (Gunakan include agar layout benar) --}}
    @include('partials.sidebarstaff')

    {{-- 2. CONTENT WRAPPER --}}
    <div id="content-wrapper" class="d-flex flex-column w-100 min-vh-100 bg-light position-relative">
        
        {{-- TOPBAR (Menu Profil ada di sini) --}}
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm px-4">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
                <i class="fa fa-bars text-royal"></i>
            </button>
            <h5 class="d-none d-sm-block m-0 fw-bold text-secondary">Kelola Data Pasien</h5>
            <ul class="navbar-nav ms-auto">
                <div class="topbar-divider d-none d-sm-block"></div>
                
                {{-- ITEM PROFIL --}}
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <span class="me-2 d-none d-lg-inline text-gray-600 small fw-bold">{{ strtoupper(auth()->user()->name) }}</span>
                        @if(auth()->user()->image != null)
                            <img class="img-profile rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #2563eb;" src="{{asset('/images/'.auth()->user()->image)}}">
                        @else
                            <div class="rounded-circle bg-royal text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; font-weight: bold; background-color: var(--royal-blue);">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        @endif
                    </a>
                    
                    {{-- DROPDOWN MENU PROFIL --}}
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
                    
                    {{-- HEADER --}}
                    <div class="card-header bg-white py-4 rounded-top-4 border-bottom-0">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-12 col-md-6">
                                <h6 class="m-0 fw-bold" style="color: var(--royal-blue);">
                                    <i class="fa-solid fa-users me-2"></i> Daftar Pasien Terdaftar
                                </h6>
                            </div>
                            <div class="col-12 col-md-6 text-end">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-gray-400"></i></span>
                                    <input type="search" id="search" class="form-control bg-light border-start-0" placeholder="Cari nama pasien..." aria-label="Search">
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
                                        <th class="text-center">Tgl Lahir</th>
                                        <th>Alamat</th>
                                        <th>Email</th>
                                        <th class="text-center">No. HP</th>
                                    </tr>
                                </thead>
                                <tbody id="old">
                                    @foreach ($user as $index => $item)
                                    <tr>
                                        <td class="text-center fw-bold text-secondary">{{ $user->firstItem() + $index }}</td>
                                        <td class="fw-bold text-dark">{{ $item->name }}</td>
                                        <td class="text-center">{{ date('d M Y', strtotime($item->birthday)) }}</td>
                                        <td>{{ Str::limit($item->address, 30) }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td class="text-center">{{ $item->telp }}</td>
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
                            {{ $user->links() }}
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
    $('#search').on('keyup', function () {
       $value = $(this).val();
       if($value){
        $('#old').hide();
        $('.card-footer').hide();
       }else{
        $('#old').show();
        $('.card-footer').show();
       }
       $.ajax({
        type:'get',
        url:'{{ URL::to('cari-pasien')}}',
        data:{'data': $value},
        success:function(data){
            $('#new').html(data);
        }
       });
    })
</script>
@endsection