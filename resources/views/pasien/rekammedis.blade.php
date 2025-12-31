@extends('maintemplatedashboard')

@section('content')

{{-- CSS Custom (Tema Pasien - Indigo) --}}
<style>
    :root {
        --indigo-primary: #4e73df;
        --indigo-light: #764ba2;
        --indigo-soft: #e7f1ff;
    }

    /* Fix Dropdown Terpotong */
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

    /* Modal Detail Styling */
    .modal-header-indigo {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
    }
    .detail-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #888;
        font-weight: 700;
        margin-bottom: 2px;
    }
    .detail-value {
        font-weight: 600;
        color: #333;
        font-size: 1rem;
    }
    .detail-box {
        background-color: #f8f9fc;
        padding: 15px;
        border-radius: 10px;
        height: 100%;
        border-left: 4px solid var(--indigo-primary);
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

<div id="wrapper" class="d-flex w-100">

    {{-- 1. SIDEBAR --}}
    @include('partials.sidebar')

    {{-- 2. CONTENT WRAPPER --}}
    <div id="content-wrapper" class="d-flex flex-column w-100 min-vh-100 bg-light position-relative">
        
        {{-- TOPBAR --}}
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm px-4" style="z-index: 1050;">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
                <i class="fa fa-bars text-indigo"></i>
            </button>
            <h5 class="d-none d-sm-block m-0 fw-bold text-secondary">Riwayat Medis</h5>
            
            <ul class="navbar-nav ms-auto">
                <div class="topbar-divider d-none d-sm-block"></div>
                
                {{-- PROFIL USER --}}
                <li class="nav-item dropdown no-arrow">
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

                {{-- CARD TABLE --}}
                <div class="card border-0 shadow-sm rounded-4 mb-5">
                    
                    {{-- Header: Judul & Search --}}
                    <div class="card-header bg-white py-4 rounded-top-4">
                        <div class="row g-3 align-items-center justify-content-between">
                            <div class="col-12 col-md-6">
                                <h6 class="m-0 fw-bold" style="color: #4e73df;">
                                    <i class="fa-solid fa-file-medical-alt me-2"></i> Daftar Riwayat Pemeriksaan
                                </h6>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </span>
                                    <input type="search" id="search" class="form-control bg-light border-start-0 small" placeholder="Cari nama atau tanggal..." aria-label="Search">
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
                                        <th class="text-center">Tanggal Periksa</th>
                                        <th>Dokter Pemeriksa</th>
                                        <th class="text-center">Detail</th>
                                    </tr>
                                </thead>
                                
                                <tbody id="alldata">
                                    @foreach ($rekam as $index => $item)
                                    <tr>
                                        <td class="text-center fw-bold text-secondary">
                                            {{ $rekam->firstItem() + $index }}
                                        </td>
                                        <td class="fw-bold text-dark">
                                            {{ $item->nama_pasien }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border">
                                                {{ date('d M Y', strtotime($item->tgl_periksa)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <i class="fa-solid fa-user-doctor me-1 text-secondary"></i> 
                                            {{-- PERBAIKAN: Menampilkan "Dr. Em" --}}
                                            Dr. Em
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id_rekam_medis }}">
                                                <i class="fa-solid fa-eye me-1"></i> Lihat
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- MODAL DETAIL --}}
                                    <div class="modal fade" id="detailModal{{ $item->id_rekam_medis }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header modal-header-indigo">
                                                    <h5 class="modal-title fw-bold">
                                                        <i class="fa-solid fa-file-prescription me-2"></i> Detail Pemeriksaan
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    
                                                    {{-- Info Utama --}}
                                                    <div class="row mb-4">
                                                        <div class="col-md-6 mb-3 mb-md-0">
                                                            <div class="detail-box">
                                                                <div class="detail-label">Dokter Pemeriksa</div>
                                                                {{-- PERBAIKAN: Menampilkan "Dr. Em" --}}
                                                                <div class="detail-value">Dr. Em</div>
                                                                <div class="detail-label mt-2">Tanggal</div>
                                                                <div class="detail-value">{{ date('d F Y', strtotime($item->tgl_periksa)) }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="detail-box border-start-0 border-end border-primary" style="border-color: #4e73df !important; border-left: 0; border-right: 4px solid;">
                                                                <div class="detail-label text-end">Diagnosa Utama</div>
                                                                <div class="detail-value text-end text-primary" style="font-size: 1.2rem;">{{ $item->nama_penyakit }}</div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Data Vital --}}
                                                    <h6 class="fw-bold text-secondary mb-3 text-uppercase small">Tanda Vital & Lab</h6>
                                                    <div class="row g-3 mb-4">
                                                        <div class="col-6 col-md-3">
                                                            <div class="p-3 bg-white border rounded text-center shadow-sm h-100">
                                                                <i class="fa-solid fa-heart-pulse text-danger mb-2"></i>
                                                                <div class="detail-label">Tensi</div>
                                                                <div class="fw-bold">{{ $item->tekanan_darah ?? '-' }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-3">
                                                            <div class="p-3 bg-white border rounded text-center shadow-sm h-100">
                                                                <i class="fa-solid fa-droplet text-warning mb-2"></i>
                                                                <div class="detail-label">Gula Darah</div>
                                                                <div class="fw-bold">{{ $item->kadar_gula_darah ?? '-' }} <small>mg/dL</small></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-3">
                                                            <div class="p-3 bg-white border rounded text-center shadow-sm h-100">
                                                                <i class="fa-solid fa-burger text-warning mb-2"></i>
                                                                <div class="detail-label">Kolesterol</div>
                                                                <div class="fw-bold">{{ $item->kadar_kolesterol ?? '-' }} <small>mg/dL</small></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-3">
                                                            <div class="p-3 bg-white border rounded text-center shadow-sm h-100">
                                                                <i class="fa-solid fa-bone text-secondary mb-2"></i>
                                                                <div class="detail-label">Asam Urat</div>
                                                                <div class="fw-bold">{{ $item->kadar_asam_urat ?? '-' }} <small>mg/dL</small></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Keterangan / Resep --}}
                                                    <div class="card bg-light border-0">
                                                        <div class="card-body">
                                                            <h6 class="fw-bold text-secondary mb-2 small text-uppercase">Catatan Dokter / Resep / Alergi</h6>
                                                            <p class="mb-2"><strong>Alergi:</strong> {{ $item->alergi_makanan ?? 'Tidak ada' }}</p>
                                                            <p class="mb-0 text-dark" style="white-space: pre-line;">{{ $item->keterangan ?? 'Tidak ada catatan tambahan.' }}</p>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- END MODAL --}}

                                    @endforeach

                                    @if($rekam->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="fa-solid fa-file-medical fa-3x mb-3 opacity-50"></i><br>
                                                Belum ada riwayat pemeriksaan.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>

                                <tbody id="konten"></tbody>
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
                $('#alldata').hide();
                $('.card-footer').hide(); 
            } else {
                $('#alldata').show();
                $('.card-footer').show();
            }

            $.ajax({
                type: 'get',
                url: '{{ URL::to('cari-rekam-pasien') }}',
                data: {'data': value},
                success: function(data){
                    $('#konten').html(data);
                }
            });
        });
    });
</script>

@endsection