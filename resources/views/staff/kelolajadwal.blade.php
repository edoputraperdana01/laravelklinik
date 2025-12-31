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

    /* Form & Buttons */
    .form-control:focus, .form-select:focus {
        border-color: var(--royal-blue);
        box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
    }
    
    .btn-royal {
        background-color: var(--royal-blue);
        color: white;
        border: none;
    }
    .btn-royal:hover {
        background-color: var(--royal-dark);
        color: white;
    }

    .page-item.active .page-link {
        background-color: var(--royal-blue);
        border-color: var(--royal-blue);
    }
    .page-link { color: var(--royal-blue); }
</style>

<div id="wrapper" class="d-flex w-100 overflow-hidden">

    {{-- 1. SIDEBAR STAFF --}}
    @include('partials.sidebarstaff')

    {{-- 2. CONTENT WRAPPER --}}
    <div id="content-wrapper" class="d-flex flex-column w-100 min-vh-100 bg-light position-relative">
        
        {{-- TOPBAR --}}
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm px-4" style="z-index: 1000;">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
                <i class="fa fa-bars text-royal"></i>
            </button>
            <h5 class="d-none d-sm-block m-0 fw-bold text-secondary">Kelola Jadwal Praktek</h5>
            <ul class="navbar-nav ms-auto">
                <div class="topbar-divider d-none d-sm-block"></div>
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="me-2 d-none d-lg-inline text-gray-600 small fw-bold">
                            {{ strtoupper(auth()->user()->name) }}
                        </span>
                        @if(auth()->user()->image != null)
                            <img class="img-profile rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #2563eb;" src="{{asset('/images/'.auth()->user()->image)}}">
                        @else
                            <div class="rounded-circle bg-royal text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; font-weight: bold;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in border-0" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">
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
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="fa-solid fa-check-circle me-2"></i> {{ session('success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @error('tgl_jadwal')
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @enderror

                {{-- CARD UTAMA --}}
                <div class="card border-0 shadow-sm rounded-4 mb-5">
                    
                    {{-- HEADER 1: Judul & Tombol Tambah --}}
                    <div class="card-header bg-white py-4 rounded-top-4 border-bottom-0 pb-0">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-12 col-md-6 mb-3 mb-md-0">
                                <h6 class="m-0 fw-bold" style="color: #2563eb;">
                                    <i class="fa-solid fa-calendar-days me-2"></i> Daftar Jadwal Dokter
                                </h6>
                            </div>
                            <div class="col-12 col-md-6 text-md-end">
                                <button type="button" class="btn btn-royal shadow-sm rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#buatjadwal">
                                    <i class="fa-solid fa-plus me-2"></i> Buat Jadwal Baru
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- HEADER 2: Filter & Search --}}
                    <div class="card-body bg-light border-top border-bottom py-3">
                        <div class="row g-2 justify-content-end">
                            {{-- Form Filter --}}
                            <div class="col-12 col-lg-7">
                                <form action="/kelola-jadwal" method="post">
                                    @csrf
                                    <div class="input-group">
                                        <select name="filter" class="form-select border-0">
                                            <option value="">-- Bulan --</option>
                                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $k => $v)
                                                <option value="{{ $k+1 }}">{{ $v }}</option>
                                            @endforeach
                                        </select>
                                        <select name="year" class="form-select border-0">
                                            <option value="2024">2024</option>
                                            <option value="2025" selected>2025</option>
                                        </select>
                                        <button type="submit" class="btn btn-secondary border-0">
                                            <i class="bi bi-filter"></i> Filter
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- Form Search --}}
                            <div class="col-12 col-lg-5">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </span>
                                    <input type="search" id="search" class="form-control bg-white border-start-0" placeholder="Cari tanggal..." aria-label="Search">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TABLE --}}
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="dataTable" width="100%" cellspacing="0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center" width="5%">No</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Jam Praktek</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Jml. Pasien</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                
                                <tbody id="alldata">
                                    @foreach ($jadwal as $index => $item)
                                    <tr>
                                        <td class="text-center fw-bold text-secondary">
                                            {{ $jadwal->firstItem() + $index }}
                                        </td>
                                        <td class="text-center fw-bold text-dark">
                                            {{ date('d M Y', strtotime($item->tgl_jadwal)) }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border">
                                                {{ $item->jam_masuk }} - {{ $item->jam_pulang }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($item->status_masuk == 1)
                                                <span class="badge rounded-pill bg-success px-3">Hadir</span>
                                            @else
                                                <span class="badge rounded-pill bg-secondary px-3">Tidak Hadir</span>
                                            @endif
                                        </td>
                                        <td class="text-center fw-bold text-primary">
                                            {{ $item->jumlah_pasien_hari_ini }}
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editjadwal{{ $item->id_jadwal }}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#hapusjadwal{{ $item->id_jadwal }}">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- MODAL EDIT --}}
                                    <div class="modal fade" id="editjadwal{{ $item->id_jadwal }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-white">
                                                    <h5 class="modal-title fw-bold text-royal">Edit Jadwal</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="/edit-jadwal" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $item->id_jadwal }}">
                                                    <div class="modal-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label small fw-bold">Tanggal</label>
                                                                <input type="date" required class="form-control" name="tgl_jadwal" value="{{ $item->tgl_jadwal }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label small fw-bold">Status Masuk</label>
                                                                <select name="status" class="form-select">
                                                                    <option value="1" {{ $item->status_masuk == 1 ? 'selected' : '' }}>Hadir</option>
                                                                    <option value="0" {{ $item->status_masuk == 0 ? 'selected' : '' }}>Tidak Hadir</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label small fw-bold">Jam Masuk</label>
                                                                <input type="time" required class="form-control" name="jam_masuk" value="{{ $item->jam_masuk }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label small fw-bold">Jam Pulang</label>
                                                                <input type="time" required class="form-control" name="jam_pulang" value="{{ $item->jam_pulang }}">
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label small fw-bold">Max Kuota Pasien</label>
                                                                <input type="number" min="0" required class="form-control" name="jumlah_maxpasien" value="{{ $item->jumlah_maxpasien }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-royal">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- MODAL HAPUS --}}
                                    <div class="modal fade" id="hapusjadwal{{ $item->id_jadwal }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Hapus Jadwal</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center py-4">
                                                    <i class="fa-solid fa-triangle-exclamation fa-3x text-danger mb-3"></i>
                                                    <p class="mb-0">Yakin ingin menghapus jadwal tanggal <strong>{{ date('d-m-Y', strtotime($item->tgl_jadwal)) }}</strong>?</p>
                                                </div>
                                                <div class="modal-footer justify-content-center bg-light">
                                                    <form action="/hapus-jadwal" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $item->id_jadwal }}">
                                                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger px-4">Ya, Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                </tbody>
                                <tbody id="konten"></tbody>
                            </table>
                        </div>
                    </div>

                    {{-- FOOTER PAGINATION --}}
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

{{-- MODAL TAMBAH JADWAL --}}
<div class="modal fade" id="buatjadwal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-royal text-white">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-calendar-plus me-2"></i> Buat Jadwal Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/tambah-jadwal" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Tanggal Jadwal</label>
                        <input type="date" required class="form-control" name="tgl_jadwal" min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold small text-secondary">Jam Masuk</label>
                            <input type="time" required class="form-control" name="jam_masuk" value="{{ old('jam_masuk') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold small text-secondary">Jam Pulang</label>
                            <input type="time" required class="form-control" name="jam_pulang" value="{{ old('jam_pulang') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">Maksimal Pasien</label>
                        <input type="number" required class="form-control" min="0" name="max_pasien" value="{{ old('max_pasien') }}" placeholder="Contoh: 20">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-royal px-4">Simpan Jadwal</button>
                </div>
            </form>
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
                $('#alldata').hide();
                $('.card-footer').hide(); 
            } else {
                $('#alldata').show();
                $('.card-footer').show();
            }

            $.ajax({
                type: 'get',
                url: '{{ URL::to('cari-jadwal') }}',
                data: {'cari-jadwal': value},
                success: function(data){
                    $('#konten').html(data);
                }
            });
        });
    });
</script>

@endsection