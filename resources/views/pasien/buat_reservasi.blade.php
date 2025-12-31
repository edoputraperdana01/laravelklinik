@extends('maintemplatedashboard')

@section('content')

<style>
    /* Styling Sederhana mengikuti tema Anda */
    :root { --indigo-primary: #4e73df; }
    .step-card { border-left: 5px solid var(--indigo-primary); }
</style>

<div id="wrapper" class="d-flex w-100 overflow-hidden">
    @include('partials.sidebar')

    <div id="content-wrapper" class="d-flex flex-column w-100 min-vh-100 bg-light">
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm px-4">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3"><i class="fa fa-bars text-primary"></i></button>
            <h5 class="m-0 fw-bold text-secondary">Buat Reservasi Baru</h5>
        </nav>

        <div class="container-fluid px-4">
            
            {{-- Alert Error --}}
            @if(session()->has('salah'))
                <div class="alert alert-danger">{{ session('salah') }}</div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    
                    {{-- LANGKAH 1: PILIH TANGGAL --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4 step-card">
                        <div class="card-header bg-white py-3">
                            <h6 class="m-0 fw-bold text-primary">Langkah 1: Cek Jadwal Dokter</h6>
                        </div>
                        <div class="card-body p-4">
                            <form action="/buat-reservasi/cek" method="POST">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-9">
                                        <label class="fw-bold">Pilih Tanggal</label>
                                        {{-- Value diisi agar saat refresh tanggal tidak hilang --}}
                                        <input type="date" class="form-control" name="tgl_reservasi" 
                                               value="{{ $tanggal_dipilih ?? '' }}" min="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <button type="submit" class="btn btn-warning w-100 fw-bold">Cek Jadwal</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- LANGKAH 2: FORM RESERVASI (Muncul jika status 'tersedia') --}}
                    @if($status_cek == 'tersedia')
                        <div class="alert alert-success">
                            <i class="fa-solid fa-check-circle me-2"></i> 
                            Jadwal Tersedia! Sisa Kuota: <strong>{{ $data_jadwal->jumlah_maxpasien }}</strong> Pasien.
                        </div>

                        <div class="card border-0 shadow-lg rounded-4 step-card" style="border-left-color: #1cc88a;">
                            <div class="card-header bg-white py-3">
                                <h6 class="m-0 fw-bold text-success">Langkah 2: Isi Data Pasien</h6>
                            </div>
                            <div class="card-body p-4">
                                {{-- Form mengarah ke route /reservasi (createreservasipost) --}}
                                <form action="/reservasi" method="POST">
                                    @csrf
                                    
                                    {{-- INPUT TERSEMBUNYI (PENTING UNTUK LOGIKA CONTROLLER ANDA) --}}
                                    <input type="hidden" name="idJadwal" value="{{ $data_jadwal->id_jadwal }}">
                                    <input type="hidden" name="tglReservasi" value="{{ $tanggal_dipilih }}">

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nama Pasien</label>
                                        <input type="text" class="form-control" name="namaPasien" value="{{ Auth::user()->name }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Keluhan</label>
                                        <textarea class="form-control" name="keluhan" rows="3" placeholder="Tuliskan keluhan anda..." required></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                        Kirim Reservasi
                                    </button>
                                </form>
                            </div>
                        </div>

                    @elseif($status_cek == 'penuh')
                        <div class="alert alert-warning">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i> 
                            Maaf, kuota antrian untuk tanggal <strong>{{ date('d-m-Y', strtotime($tanggal_dipilih)) }}</strong> sudah penuh.
                        </div>

                    @elseif($status_cek == 'tidak_ada')
                        <div class="alert alert-danger">
                            <i class="fa-solid fa-circle-xmark me-2"></i> 
                            Dokter tidak memiliki jadwal praktek pada tanggal <strong>{{ date('d-m-Y', strtotime($tanggal_dipilih)) }}</strong>.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection