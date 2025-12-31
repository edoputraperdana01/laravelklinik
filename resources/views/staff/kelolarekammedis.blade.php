@extends('maintemplatedashboard')
@section('content')

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
    }
    .btn-royal { background-color: var(--royal-blue); color: white; border: none; }
    .btn-royal:hover { background-color: var(--royal-dark); color: white; }
    .page-item.active .page-link { background-color: var(--royal-blue); border-color: var(--royal-blue); }
    .page-link { color: var(--royal-blue); }
</style>

<div id="wrapper" class="d-flex w-100 overflow-hidden">

    @include('partials.sidebarstaff')

    <div id="content-wrapper" class="d-flex flex-column w-100 min-vh-100 bg-light position-relative">
        
        {{-- TOPBAR --}}
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm px-4">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3"><i class="fa fa-bars text-royal"></i></button>
            <h5 class="d-none d-sm-block m-0 fw-bold text-secondary">Kelola Rekam Medis</h5>
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

                    {{-- MENU DROPDOWN (INI YANG DITAMBAHKAN) --}}
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

        <div id="content" class="flex-grow-1">
            <div class="container-fluid px-4">

                @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4">
                    <i class="fa-solid fa-check-circle me-2"></i> {{ session('success')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4 mb-5">
                    
                    <div class="card-header bg-white py-4 rounded-top-4 border-bottom-0">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-12 col-md-5 mb-3 mb-md-0">
                                <h6 class="m-0 fw-bold" style="color: var(--royal-blue);">
                                    <i class="fa-solid fa-file-medical me-2"></i> Daftar Rekam Medis
                                </h6>
                            </div>
                            <div class="col-12 col-md-7 text-end">
                                <div class="d-flex gap-2 justify-content-md-end">
                                    <a href="/tambah-rekam-medis" class="btn btn-royal shadow-sm rounded-pill px-4">
                                        <i class="fa-solid fa-plus me-2"></i> Buat Baru
                                    </a>
                                    <div class="input-group" style="max-width: 250px;">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-gray-400"></i></span>
                                        <input type="search" id="search" class="form-control bg-light border-start-0" placeholder="Cari..." aria-label="Search">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" width="100%" cellspacing="0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama Pasien</th>
                                        <th>Dokter Pemeriksa</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="old">
                                    @foreach ($rekam as $index => $item)
                                    <tr>
                                        <td class="text-center fw-bold text-secondary">{{ $rekam->firstItem() + $index }}</td>
                                        <td class="fw-bold">{{ $item->nama_pasien}}</td>
                                        <td>{{ $item->user->name ?? $item->name }}</td>
                                        <td class="text-center">{{ date('d M Y', strtotime($item->tgl_periksa))}}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#edit_rekam_medis{{ $item->id_rekam_medis }}"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#hapus_rekam_medis{{ $item->id_rekam_medis }}"><i class="fa-solid fa-trash-can"></i></button>
                                        </td>
                                    </tr>
                                    
                                    {{-- MODAL HAPUS --}}
                                    <div class="modal fade" id="hapus_rekam_medis{{ $item->id_rekam_medis }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Hapus Data</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center py-4">
                                                    <p>Yakin ingin menghapus rekam medis ini?</p>
                                                    <form action="/hapus-rekam-medis" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $item->id_rekam_medis }}">
                                                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- MODAL EDIT --}}
                                    <div class="modal fade" id="edit_rekam_medis{{ $item->id_rekam_medis }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-white">
                                                    <h5 class="modal-title fw-bold text-royal">Edit Rekam Medis</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="/edit-rekam-medis" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id_user" value="{{ $item->id_rekam_medis }}">
                                                    <div class="modal-body">
                                                        
                                                        {{-- BAGIAN 1: INFO UTAMA --}}
                                                        <h6 class="text-uppercase fw-bold text-secondary mb-3 small border-bottom pb-2">Data Pasien</h6>
                                                        <div class="row g-3 mb-4">
                                                            <div class="col-md-6">
                                                                <label class="form-label small fw-bold">Nama Pasien</label>
                                                                <input type="text" name="nama_pasien" class="form-control" value="{{ $item->nama_pasien }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label small fw-bold">Usia</label>
                                                                <input type="text" name="usia" class="form-control" value="{{ $item->usia }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label small fw-bold">Tanggal Periksa</label>
                                                                <input type="date" name="tgl_periksa" class="form-control" value="{{ $item->tgl_periksa }}">
                                                            </div>
                                                        </div>

                                                        {{-- BAGIAN 2: MEDIS & VITAL --}}
                                                        <h6 class="text-uppercase fw-bold text-secondary mb-3 small border-bottom pb-2">Diagnosa & Tanda Vital</h6>
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-12">
                                                                <label class="form-label small fw-bold">Diagnosa / Penyakit</label>
                                                                <input type="text" name="nama_penyakit" class="form-control" value="{{ $item->nama_penyakit }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label small fw-bold">Tekanan Darah</label>
                                                                <input type="text" name="tekanan_darah" class="form-control" value="{{ $item->tekanan_darah }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label small fw-bold">Gula Darah</label>
                                                                <input type="number" name="kadar_gula_darah" class="form-control" value="{{ $item->kadar_gula_darah }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label small fw-bold">Kolesterol</label>
                                                                <input type="number" name="kadar_kolesterol" class="form-control" value="{{ $item->kadar_kolesterol }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label small fw-bold">Asam Urat</label>
                                                                <input type="number" step="0.1" name="kadar_asam_urat" class="form-control" value="{{ $item->kadar_asam_urat }}">
                                                            </div>
                                                        </div>

                                                        {{-- BAGIAN 3: CATATAN --}}
                                                        <div class="row g-3">
                                                            <div class="col-12">
                                                                <label class="form-label small fw-bold">Alergi Makanan/Obat</label>
                                                                <input type="text" name="alergi_makanan" class="form-control" value="{{ $item->alergi_makanan }}">
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label small fw-bold">Keterangan / Resep</label>
                                                                <textarea class="form-control" name="keterangan" rows="3">{{ $item->keterangan }}</textarea>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-royal">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                                <tbody id="new"></tbody>
                            </table>
                        </div>
                    </div>

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $('#search').on('keyup',function () {
       $value=$(this).val();
       if($value){ $('#old').hide(); $('.card-footer').hide(); }
       else{ $('#old').show(); $('.card-footer').show(); }
       
       $.ajax({
        type:'get',
        url:'{{ URL::to('cari-rekam-medis')}}',
        data:{'data': $value},
        success:function(data){ $('#new').html(data); }
       });
    })
</script>
@endsection