<style>
  .footer-gradient {
    /* Gradasi modern: Biru ke Ungu lembut */
    background: linear-gradient(135deg, #0061f2 0%, #6900f2 100%); 
    color: white;
  }
  .footer-gradient a {
    color: rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
    text-decoration: none;
  }
  .footer-gradient a:hover {
    color: #fff;
    transform: translateX(5px); /* Efek geser sedikit saat di-hover */
  }
  .social-icon-btn {
    background: rgba(255,255,255,0.1);
    width: 40px;
    height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin: 0 5px;
    transition: 0.3s;
  }
  .social-icon-btn:hover {
    background: white;
    color: #6900f2;
    transform: translateY(-3px);
  }
</style>

<footer class="footer-gradient text-lg-start pt-5 pb-4">
  <div class="container text-center text-md-start">
    <div class="row text-center text-md-start">
      
      <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
        <h5 class="text-uppercase mb-4 fw-bold text-white">
            <i class="fas fa-heartbeat me-2"></i>SEHATIN
        </h5>
        <p>
          Solusi kesehatan digital terpadu untuk Anda dan keluarga. Konsultasi dokter kini lebih mudah dan cepat.
        </p>
        <div class="mt-4">
            <a href="#" class="social-icon-btn"><i class="fab fa-whatsapp"></i></a>
             <a href="#" class="social-icon-btn"><i class="fab fa-instagram"></i></a>
             <a href="#" class="social-icon-btn"><i class="fab fa-twitter"></i></a>
        </div>
      </div>

      <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
        <h6 class="text-uppercase mb-4 fw-bold text-warning">Akses Cepat</h6>
        <p><a href="/login">Login Akun</a></p>
        <p><a href="/register">Daftar Baru</a></p>
        <p><a href="#">Cari Dokter</a></p>
        <p><a href="#">Tentang Kami</a></p>
      </div>

      <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
        <h6 class="text-uppercase mb-4 fw-bold text-warning">Lokasi Praktek</h6>
        <p><i class="fas fa-hospital-alt me-2"></i> dr. Em Clinic</p>
        <p class="small">Jl Gubeng Kertajaya No 12, Surabaya, Indonesia</p>
        <p class="small mt-2"><i class="fas fa-building me-2"></i> PT. Semen Indonesia, Gresik</p>
      </div>

      <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
        <h6 class="text-uppercase mb-4 fw-bold text-warning">Hubungi Kami</h6>
        <p><i class="fas fa-home me-3"></i> Surabaya, ID</p>
        <p><i class="fas fa-envelope me-3"></i> emsandi@email.com</p>
        <p><i class="fas fa-phone me-3"></i> +62 811 222 333</p>
      </div>
      
    </div>
    
    <hr class="mb-4 mt-4" style="border-color: rgba(255,255,255,0.3);">
    
    <div class="row align-items-center">
      <div class="col-md-7 col-lg-8">
        <p class="text-center text-md-start">© 2025 Copyright:
          <strong class="text-warning">Kelompok 4 SEHATIN</strong>
        </p>
      </div>
    </div>
  </div>
</footer>