@extends('maintemplate')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">Selamat Datang</h3>
                        <p class="text-muted small">Silakan login ke akun Anda</p>
                    </div>

                    @isset($registberhasil)
                    <div class="alert alert-success alert-dismissible fade show small" role="alert">
                        <i class="bi bi-check-circle me-1"></i> Akun berhasil dibuat, silakan login.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endisset

                    @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show small" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session()->has('salah'))
                    <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                        <i class="bi bi-exclamation-triangle me-1"></i> {{ session('salah')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form method="POST" action="/login" class="user">
                        @csrf
                        
                        <div class="form-floating mb-3">
                            <input type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                name="email" 
                                id="floatingEmail" 
                                placeholder="name@example.com"
                                value="{{ session('email') ? session('email') : old('email') }}" 
                                autofocus>
                            <label for="floatingEmail">Email Address</label>
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                name="password" 
                                id="floatingPassword" 
                                placeholder="Password">
                            <label for="floatingPassword">Password</label>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mb-4">
                            <a href="/lupa-password" class="text-decoration-none small text-muted">Lupa Password?</a>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Login
                            </button>
                        </div>

                    </form>

                    <div class="text-center">
                        <p class="small text-muted mb-0">Belum punya akun? 
                            <a href="/register" class="text-decoration-none fw-bold text-primary">Daftar Sekarang</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fa; /* Warna abu-abu sangat muda */
    }
    .form-floating > label {
        color: #6c757d;
    }
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }
</style>
@endsection