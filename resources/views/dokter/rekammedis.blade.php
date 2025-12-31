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
        font-size: 0.85rem;
        text-transform: uppercase;
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
            <h5 class="d-none d-sm-block m-0 fw-bold text-secondary">Rekam Medis Pasien</h5>
            <ul class="navbar-nav ms-auto">
                <div class="topbar-divider d-none d-sm-block"></div>
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="me-2 d-none d-lg-inline text-gray-600 small fw-bold">
                            {{ strtoupper(auth()->user()->name ?? 'GUEST') }}
                        </span>
                        @if(auth()->user() && auth()->user()->image != null)
                            <img class="img-profile rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #0f766e;" src="{{asset('/images/'.auth()->user()->image)}}">
                        @else
                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; font-weight: bold; background-color: #0f766e;">
                                {{ auth()->user() ? strtoupper(substr(auth()->user()->name, 0, 1)) : '?' }}
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
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="fa-solid fa-check-circle me-2"></i> {{ session('success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Card Table --}}
                <div class="card border-0 shadow-sm rounded-4 mb-5">
                    
                    {{-- Header: Judul, Search, Tombol Tambah --}}
                    <div class="card-header bg-white py-4 rounded-top-4">
                        <div class="row g-3 align-items-center justify-content-between">
                            
                            {{-- Judul --}}
                            <div class="col-12 col-lg-4">
                                <h6 class="m-0 fw-bold" style="color: #0f766e;">
                                    <i class="fa-solid fa-notes-medical me-2"></i> Daftar Rekam Medis
                                </h6>
                            </div>

                            {{-- Actions --}}
                            <div class="col-12 col-lg-8">
                                <div class="row g-2 justify-content-lg-end">
                                    {{-- Search --}}
                                    <div class="col-12 col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-search text-gray-400"></i>
                                            </span>
                                            <input type="search" id="search" class="form-control bg-light border-start-0 small" placeholder="Cari nama pasien..." aria-label="Search">
                                        </div>
                                    </div>
                                    
                                    {{-- Tombol Tambah --}}
                                    <div class="col-12 col-md-4">
                                        <a href="/tambah-rekam-medis-dokter" class="btn btn-medical w-100 shadow-sm">
                                            <i class="fa-solid fa-plus me-1"></i> Buat Baru
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Table Body --}}
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center" width="5%">No</th>
                                        <th>Nama Pasien</th>
                                        <th>Dokter Pemeriksa</th>
                                        <th class="text-center">Tanggal Periksa</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                
                                <tbody id="old">
                                    @foreach ($rekam as $index => $item)
                                    <tr>
                                        <td class="text-center fw-bold text-secondary">
                                            {{ $rekam->firstItem() + $index }}
                                        </td>
                                        <td class="fw-bold text-dark">
                                            {{ $item->nama_pasien }}
                                        </td>
                                        <td>
                                            <i class="fa-solid fa-user-doctor text-secondary me-1"></i> 
                                            {{-- PERBAIKAN: Menampilkan "Dr. Em" secara hardcode --}}
                                            Dr. Em
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border">
                                                {{ date('d M Y', strtotime($item->tgl_periksa)) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#edit_rekam_medis{{ $item->id_rekam_medis }}" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#hapus_rekam_medis{{ $item->id_rekam_medis }}" title="Hapus">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- MODAL HAPUS --}}
                                    <div class="modal fade" id="hapus_rekam_medis{{ $item->id_rekam_medis }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center py-4">
                                                    <i class="fa-solid fa-triangle-exclamation fa-3x text-danger mb-3"></i>
                                                    <p class="mb-0">Apakah Anda yakin ingin menghapus rekam medis pasien <strong>{{ $item->nama_pasien }}</strong>?</p>
                                                    <p class="small text-muted">Data yang dihapus tidak dapat dikembalikan.</p>
                                                </div>
                                                <div class="modal-footer justify-content-center bg-light">
                                                    <form action="/hapus-rekam-medis-dokter" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $item->id_rekam_medis }}">
                                                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger px-4">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- MODAL EDIT --}}
                                    <div class="modal fade" id="edit_rekam_medis{{ $item->id_rekam_medis }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-white">
                                                    <h5 class="modal-title fw-bold" style="color: #0f766e;">
                                                        <i class="fa-solid fa-pen-to-square me-2"></i> Edit Rekam Medis
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                
                                                <form action="/edit-rekam-medis-dokter" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id_user" value="{{ $item->id_rekam_medis }}">
                                                    
                                                    <div class="modal-body bg-light">
                                                        <div class="card border-0 shadow-sm p-3">
                                                            <div class="row g-3">
                                                                {{-- Data Pasien --}}
                                                                <div class="col-md-6">
                                                                    <label class="form-label small fw-bold text-muted">Nama Pasien</label>
                                                                    <input type="text" name="nama_pasien" class="form-control" value="{{ $item->nama_pasien }}" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label small fw-bold text-muted">Usia</label>
                                                                    <input type="number" name="usia" class="form-control" value="{{ $item->usia }}">
                                                                </div>

                                                                {{-- Data Medis --}}
                                                                <div class="col-md-6">
                                                                    <label class="form-label small fw-bold text-muted">Nama Penyakit (Diagnosa)</label>
                                                                    <input type="text" name="nama_penyakit" class="form-control" value="{{ $item->nama_penyakit }}">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label small fw-bold text-muted">Tanggal Periksa</label>
                                                                    <input type="date" name="tgl_periksa" class="form-control" value="{{ $item->tgl_periksa }}">
                                                                </div>

                                                                {{-- Hasil Lab --}}
                                                                <div class="col-md-4">
                                                                    <label class="form-label small fw-bold text-muted">Asam Urat</label>
                                                                    <input type="number" step="0.1" name="kadar_asam_urat" class="form-control" value="{{ $item->kadar_asam_urat }}">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label small fw-bold text-muted">Gula Darah</label>
                                                                    <input type="number" name="kadar_gula_darah" class="form-control" value="{{ $item->kadar_gula_darah }}">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="form-label small fw-bold text-muted">Kolesterol</label>
                                                                    <input type="number" name="kadar_kolesterol" class="form-control" value="{{ $item->kadar_kolesterol }}">
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <label class="form-label small fw-bold text-muted">Tekanan Darah</label>
                                                                    <input type="text" name="tekanan_darah" class="form-control" value="{{ $item->tekanan_darah }}" placeholder="Contoh: 120/80">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label small fw-bold text-muted">Alergi Makanan</label>
                                                                    <input type="text" name="alergi_makanan" class="form-control" value="{{ $item->alergi_makanan }}">
                                                                </div>

                                                                <div class="col-12">
                                                                    <label class="form-label small fw-bold text-muted">Keterangan / Resep</label>
                                                                    <textarea class="form-control" name="keterangan" rows="3">{{ $item->keterangan }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="modal-footer bg-white">
                                                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-medical px-4">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- END MODAL EDIT --}}
                                    
                                    @endforeach

                                    @if($rekam->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="fa-solid fa-notes-medical fa-3x mb-3 opacity-50"></i><br>
                                                Belum ada data rekam medis.
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
                            {{ $rekam->links() }}
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
                url: '{{ URL::to('cari-rekam-medis-dokter') }}',
                data: {'data': value},
                success: function(data){
                    $('#new').html(data);
                }
            });
        });
    });
</script>

@endsection