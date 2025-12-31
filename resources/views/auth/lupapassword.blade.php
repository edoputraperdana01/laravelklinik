@extends('maintemplate')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">Lupa Password?</h3>
                        <p class="text-muted small">Jangan khawatir, cukup masukkan email Anda di bawah ini dan kami akan mengirimkan link untuk mereset password.</p>
                    </div>

                    @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show small" role="alert">
                        <i class="bi bi-envelope-check me-1"></i> {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form method="POST" action="/lupa-password" class="user">
                        @csrf
                        
                        <div class="form-floating mb-4">
                            <input type="email" 
                                class="form-control @if($errors->has('email')) is-invalid @endif" 
                                name="email" 
                                id="floatingEmail" 
                                placeholder="name@example.com" 
                                autofocus>
                            <label for="floatingEmail">Masukkan Email Terdaftar</label>
                            
                            @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i> Email tidak ditemukan
                                </div>
                            @endif
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold">
                                <i class="bi bi-send-fill me-2"></i> Kirim Link Reset
                            </button>
                        </div>

                    </form>

                    <div class="text-center">
                        <a href="/login" class="text-decoration-none small text-muted">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection