@extends('maintemplate')

@section('content')

{{-- Custom CSS untuk Landing Page --}}
<style>
    :root {
        --royal-blue: #2563eb; /* Biru Kerajaan */
        --royal-dark: #1e40af;
        --royal-gold: #f59e0b; /* Aksen Emas */
        --royal-soft: #eff6ff;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
        position: relative;
        overflow: hidden;
    }
    
    .hero-badge {
        background-color: rgba(37, 99, 235, 0.1);
        color: var(--royal-blue);
        border: 1px solid rgba(37, 99, 235, 0.2);
    }

    .btn-royal {
        background-color: var(--royal-blue);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-royal:hover {
        background-color: var(--royal-dark);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
    }

    /* Card Styling */
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        border-color: var(--royal-blue);
    }

    /* Icon Box */
    .icon-box-royal {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--royal-blue) 0%, var(--royal-dark) 100%);
        color: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
    }

    /* Input Styling */
    .form-control:focus, .form-select:focus {
        border-color: var(--royal-blue);
        box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.25);
    }
</style>

{{-- 1. HERO SECTION --}}
<section class="hero-section d-flex align-items-center min-vh-75 py-5">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center flex-column-reverse flex-lg-row">
            
            {{-- Text Content --}}
            <div class="col-lg-6 mt-5 mt-lg-0 text-center text-lg-start">
                <div class="d-inline-flex align-items-center hero-badge px-3 py-2 rounded-pill fw-bold mb-4">
                    <span class="bg-primary text-white rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;"><i class="fa-solid fa-check" style="font-size: 10px;"></i></span>
                    Layanan Kesehatan Terpercaya
                </div>
                
                <h1 class="display-4 fw-bold text-dark mb-3 lh-base">
                    Solusi Kesehatan Modern bersama <span style="color: var(--royal-blue);">dr. Em</span>
                </h1>
                
                <p class="lead text-muted mb-5 pe-lg-5">
                    Kami menghadirkan pelayanan medis yang ramah, cepat, dan profesional. Kesehatan Anda dan keluarga adalah prioritas utama kami.
                </p>
                
                <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3">
                    <a href="#cekjadwal" class="btn btn-royal btn-lg rounded-pill px-5 py-3 fw-bold">
                        Buat Janji Temu
                    </a>
                    <a href="#tentangkami" class="btn btn-outline-secondary btn-lg rounded-pill px-5 py-3 fw-bold">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            {{-- Image Content --}}
            <div class="col-lg-6 text-center position-relative">
                <div class="position-absolute top-50 start-50 translate-middle bg-primary opacity-10 rounded-circle" style="width: 400px; height: 400px; filter: blur(60px); z-index: -1;"></div>
                <img src="img/landingimage.png" class="img-fluid position-relative" width="500" alt="Dokter Illustration" style="filter: drop-shadow(0 20px 40px rgba(0,0,0,0.15));">
            </div>
        </div>
    </div>
</section>

{{-- 2. CEK JADWAL SECTION --}}
<section id="cekjadwal" class="py-5 bg-white position-relative">
    <div class="container" style="margin-top: -80px; position: relative; z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <div class="card-header text-center py-4 text-white" style="background: var(--royal-blue);">
                        <h4 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-check me-2"></i>Cek Ketersediaan Jadwal</h4>
                    </div>
                    
                    <div class="card-body p-4 p-md-5">
                        <form action="/" method="post">
                            @csrf
                            <div class="row align-items-end justify-content-center g-3">
                                <div class="col-md-8">
                                    <label for="floatingDate" class="form-label fw-bold text-secondary">Pilih Tanggal Kunjungan</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light"><i class="fa-solid fa-calendar-days text-primary"></i></span>
                                        <input type="date" class="form-control bg-light" name="tgl" id="floatingDate" 
                                               min="{{ date('Y-m-d') }}" required style="border-left: 0;">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-warning btn-lg w-100 fw-bold text-dark shadow-sm" type="submit" name="submit">
                                        Cari Jadwal
                                    </button>
                                </div>
                            </div>
                        </form>

                        {{-- Hasil Pencarian Jadwal --}}
                        @isset($jumlahjadwal)
                            <div class="mt-4 text-center">
                                @if ($jumlahjadwal > 0)
                                    <div class="alert alert-success d-inline-block px-5 py-3 rounded-4 shadow-sm border-0" role="alert">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-solid fa-circle-check fa-2x me-3"></i>
                                            <div class="text-start">
                                                <h5 class="fw-bold mb-0">Jadwal Tersedia!</h5>
                                                <p class="mb-0">Dokter praktek pada tanggal <strong>{{ date('d F Y', strtotime($tgl_jadwal)) }}</strong>.</p>
                                                <a href="/reservasi" class="btn btn-sm btn-success mt-2 rounded-pill px-4">Lanjut Reservasi <i class="fa-solid fa-arrow-right ms-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-danger d-inline-block px-5 py-3 rounded-4 shadow-sm border-0" role="alert">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-solid fa-circle-xmark fa-2x me-3"></i>
                                            <div class="text-start">
                                                <h5 class="fw-bold mb-0">Jadwal Tidak Ditemukan</h5>
                                                <p class="mb-0">Maaf, tidak ada praktek pada tanggal <strong>{{ date('d F Y', strtotime($tgl_jadwal)) }}</strong>.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endisset
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- 3. TENTANG KAMI --}}
<section id="tentangkami" class="py-5" style="background-color: #f8fafc;">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            
            <div class="col-lg-6">
                <div class="position-relative ps-4 pt-4">
                    {{-- Dekorasi Kotak --}}
                    <div class="position-absolute top-0 start-0 bg-warning rounded-4" style="width: 100px; height: 100px; z-index: 0;"></div>
                    <div class="position-absolute bottom-0 end-0 bg-primary rounded-4" style="width: 150px; height: 150px; opacity: 0.1; z-index: 0; margin-bottom: -20px; margin-right: -20px;"></div>
                    
                    <img src="/img/qq.jpg" class="img-fluid rounded-4 shadow w-100 position-relative" style="z-index: 1; object-fit: cover;" alt="Tentang Kami">
                </div>
            </div>

            <div class="col-lg-6">
                <h6 class="text-uppercase fw-bold text-primary mb-2" style="letter-spacing: 2px;">Tentang Kami</h6>
                <h2 class="fw-bold mb-4 text-dark">Layanan Medis Profesional dengan Sentuhan Personal</h2>
                <p class="text-muted mb-4 lead" style="font-size: 1rem;">
                    dr. Em berlokasi strategis di kompleks PT. Semen Indonesia, Gresik. Kami menggabungkan keahlian medis dengan teknologi terkini untuk memberikan diagnosis dan perawatan yang akurat.
                </p>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card card-hover border-0 shadow-sm h-100 bg-white">
                            <div class="card-body p-4">
                                <div class="icon-box-royal mb-3">
                                    <i class="fa-solid fa-stethoscope fa-lg"></i>
                                </div>
                                <h6 class="fw-bold">Pemeriksaan Umum</h6>
                                <p class="text-muted small mb-0">Diagnosis penyakit umum dan perawatan dasar.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-hover border-0 shadow-sm h-100 bg-white">
                            <div class="card-body p-4">
                                <div class="icon-box-royal mb-3" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                                    <i class="fa-solid fa-heart-pulse fa-lg"></i>
                                </div>
                                <h6 class="fw-bold">Konsultasi</h6>
                                <p class="text-muted small mb-0">Saran kesehatan preventif dan kuratif.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- 4. HUBUNGI KAMI --}}
<section id="hubungikami" class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-uppercase fw-bold text-primary mb-2" style="letter-spacing: 2px;">Kontak</h6>
            <h2 class="fw-bold text-dark">Hubungi Kami</h2>
        </div>

        <div class="row g-0 rounded-4 overflow-hidden shadow-lg">
            
            {{-- Info Kontak (Kiri) --}}
            <div class="col-lg-5 text-white p-5 d-flex flex-column justify-content-center" style="background: linear-gradient(180deg, var(--royal-blue) 0%, var(--royal-dark) 100%);">
                <h3 class="fw-bold mb-4">Informasi Kontak</h3>
                <p class="mb-5 opacity-75">Silakan hubungi kami melalui saluran berikut untuk respon cepat.</p>

                <div class="d-flex align-items-start mb-4">
                    <i class="fa-solid fa-location-dot fa-lg mt-1 me-3 text-warning"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Alamat</h6>
                        <p class="mb-0 small opacity-75">PT. Semen Indonesia (Persero) Tbk., Jl. Veteran, Sidokumpul, Gresik, 61122.</p>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <i class="fa-solid fa-phone fa-lg me-3 text-warning"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Telepon</h6>
                        <p class="mb-0 small opacity-75">+62 811 222 333</p>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-envelope fa-lg me-3 text-warning"></i>
                    <div>
                        <h6 class="fw-bold mb-1">Email</h6>
                        <p class="mb-0 small opacity-75">emsandi@email.com</p>
                    </div>
                </div>
            </div>

            {{-- Form Pesan (Kanan) --}}
            <div class="col-lg-7 bg-white p-5">
                <h4 class="fw-bold text-dark mb-4">Kirim Pesan</h4>
                <form action="/hubungi-mail" method="POST"> 
                    @csrf 
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                            <input type="text" class="form-control bg-light border-0 py-3" name="name" placeholder="John Doe" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Email</label>
                            <input type="email" class="form-control bg-light border-0 py-3" name="email" placeholder="nama@email.com" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Pesan</label>
                            <textarea class="form-control bg-light border-0 py-3" name="message" rows="4" placeholder="Tuliskan pesan Anda di sini..." required></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-dark w-100 py-3 fw-bold rounded-3">
                                Kirim Pesan <i class="fa-solid fa-paper-plane ms-2"></i>
                            </button>
                        </div>
                    </div>
                </form>

                @if(session()->has('success'))
                    <div class="alert alert-success mt-4 d-flex align-items-center" role="alert">
                        <i class="fa-solid fa-check-circle me-2"></i> 
                        <div>{{ session('success')}}</div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

@endsection