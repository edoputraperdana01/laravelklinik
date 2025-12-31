@extends('maintemplatedashboard')

@section('content')

{{-- CSS Custom (Royal Theme) --}}
<style>
    :root {
        --royal-blue: #2563eb;
        --royal-dark: #1e40af;
        --royal-soft: #eff6ff;
    }
    
    /* Form Styling */
    .form-control:focus, .form-select:focus {
        border-color: var(--royal-blue);
        box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
    }
    .form-label {
        font-weight: 600;
        color: #4b5563;
        font-size: 0.85rem;
    }
    
    /* Button Styling */
    .btn-royal {
        background-color: var(--royal-blue);
        color: white;
        border: none;
        transition: all 0.3s;
    }
    .btn-royal:hover {
        background-color: var(--royal-dark);
        color: white;
        transform: translateY(-2px);
    }
</style>

<div id="wrapper" class="d-flex w-100 overflow-hidden">

    {{-- SIDEBAR --}}
    @include('partials.sidebarstaff')

    {{-- CONTENT WRAPPER --}}
    <div id="content-wrapper" class="d-flex flex-column w-100 min-vh-100 bg-light position-relative">
        
        {{-- TOPBAR --}}
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm px-4">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
                <i class="fa fa-bars text-royal"></i>
            </button>
            <h5 class="d-none d-sm-block m-0 fw-bold text-secondary">Form Rekam Medis</h5>
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
                </li>
            </ul>
        </nav>

        {{-- MAIN CONTENT --}}
        <div id="content" class="flex-grow-1">
            <div class="container-fluid px-4">

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        
                        <div class="card border-0 shadow-sm rounded-4 mb-5">
                            
                            {{-- HEADER --}}
                            <div class="card-header bg-white py-4 rounded-top-4 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="bg-royal-soft text-primary p-3 rounded-circle me-3" style="background-color: var(--royal-soft); color: var(--royal-blue);">
                                        <i class="fa-solid fa-file-medical fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="m-0 fw-bold text-royal">Buat Rekam Medis Baru</h5>
                                        <p class="mb-0 small text-muted">Isi data pemeriksaan pasien dengan lengkap.</p>
                                    </div>
                                </div>
                            </div>

                            {{-- FORM BODY --}}
                            <div class="card-body p-4 p-md-5">
                                <form action="/tambah-rekam-medis" method="POST">
                                    @csrf
                                    
                                    {{-- BAGIAN 1: DATA PASIEN --}}
                                    <h6 class="text-uppercase fw-bold text-secondary mb-3 small border-bottom pb-2">Data Pasien & Pemeriksaan</h6>
                                    
                                    <div class="row g-4 mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Pilih Akun Pasien <span class="text-danger">*</span></label>
                                            <select name="nama_user" required class="form-select js-example-basic-single">
                                                <option selected disabled>-- Cari Nama Pasien --</option>
                                                @foreach($pasien as $key)
                                                    <option value="{{ $key->id }}">{{ $key->name }} - {{ $key->email }}</option>
                                                @endforeach
                                            </select>
                                            @error('nama_user')
                                                <div class="small text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal Periksa <span class="text-danger">*</span></label>
                                            <input required class="form-control" type="date" name="tgl_periksa" value="{{ old('tgl_periksa', date('Y-m-d')) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Lengkap (Di Rekam Medis) <span class="text-danger">*</span></label>
                                            <input required class="form-control" type="text" name="nama_pasien" value="{{ old('nama_pasien') }}" placeholder="Sesuai KTP">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Usia <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input required class="form-control" type="number" min="0" name="usia" value="{{ old('usia') }}" placeholder="0">
                                                <span class="input-group-text bg-light">Tahun</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- BAGIAN 2: DIAGNOSA & VITAL --}}
                                    <h6 class="text-uppercase fw-bold text-secondary mb-3 small border-bottom pb-2 mt-5">Diagnosa & Tanda Vital</h6>
                                    
                                    <div class="row g-4 mb-4">
                                        <div class="col-12">
                                            <label class="form-label">Diagnosa Utama / Nama Penyakit <span class="text-danger">*</span></label>
                                            <input required class="form-control form-control-lg" type="text" name="nama_penyakit" value="{{ old('nama_penyakit') }}" placeholder="Contoh: Hipertensi Grade 1">
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <label class="form-label">Tekanan Darah</label>
                                            <input class="form-control" type="text" name="tekanan_darah" value="{{ old('tekanan_darah') }}" placeholder="120/80">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Gula Darah (mg/dL)</label>
                                            <input class="form-control" type="number" name="kadar_gula_darah" value="{{ old('kadar_gula_darah') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Kolesterol (mg/dL)</label>
                                            <input class="form-control" type="number" name="kadar_kolesterol" value="{{ old('kadar_kolesterol') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Asam Urat (mg/dL)</label>
                                            <input class="form-control" type="number" step="0.1" name="kadar_asam_urat" value="{{ old('kadar_asam_urat') }}">
                                        </div>
                                    </div>

                                    {{-- BAGIAN 3: LAIN-LAIN --}}
                                    <div class="mb-4">
                                        <label class="form-label">Alergi Makanan / Obat</label>
                                        <input class="form-control" type="text" name="alergi_makanan" value="{{ old('alergi_makanan') }}" placeholder="Kosongkan jika tidak ada">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Catatan Dokter / Resep / Keterangan</label>
                                        <textarea class="form-control" name="keterangan" rows="5" placeholder="Tuliskan detail pemeriksaan, resep obat, atau saran dokter...">{{ old('keterangan') }}</textarea>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-5">
                                        <a href="/kelola-rekam-medis" class="btn btn-light border px-4">
                                            <i class="fa-solid fa-arrow-left me-2"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-royal px-5 py-2 shadow fw-bold rounded-pill">
                                            <i class="fa-solid fa-paper-plane me-2"></i> Simpan Data
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- SCRIPT SELECT2 (Agar Pilihan User Bisa di-Search) --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Cari Nama Pasien --',
            allowClear: true
        });
    });
</script>

@endsection