@extends('maintemplate')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 col-xl-5">
            
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-md-5">
                    
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">Buat Akun Baru</h3>
                        <p class="text-muted small">Lengkapi data diri Anda untuk mendaftar</p>
                    </div>

                    <form method="POST" action="/register" class="user">
                        @csrf

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                name="name" id="floatingName" placeholder="Nama Pasien" 
                                value="{{ old('name') }}" autofocus>
                            <label for="floatingName">Nama Pasien</label>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="date" class="form-control @error('birthday') is-invalid @enderror" 
                                name="birthday" id="floatingBirth" placeholder="Tanggal Lahir" 
                                value="{{ old('birthday') }}">
                            <label for="floatingBirth">Tanggal Lahir</label>
                            @error('birthday')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                name="address" id="floatingAddress" placeholder="Alamat" 
                                value="{{ old('address') }}">
                            <label for="floatingAddress">Alamat Domisili</label>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control @error('telp') is-invalid @enderror" 
                                name="telp" id="floatingTelp" placeholder="08xxx" 
                                value="{{ old('telp') }}">
                            <label for="floatingTelp">Nomor WhatsApp / HP</label>
                            @error('telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" id="floatingEmail" placeholder="name@example.com" 
                                value="{{ old('email') }}">
                            <label for="floatingEmail">Alamat Email</label>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                        name="password" id="floatingPass" placeholder="Password">
                                    <label for="floatingPass">Password</label>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                        name="password_confirmation" id="floatingConfirm" placeholder="Konfirmasi">
                                    <label for="floatingConfirm">Ulangi Password</label>
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold">
                                <i class="bi bi-person-plus-fill me-2"></i> Daftar Sekarang
                            </button>
                        </div>

                    </form>

                    <div class="text-center">
                        <p class="small text-muted mb-0">Sudah memiliki akun? 
                            <a href="/login" class="text-decoration-none fw-bold text-primary">Login disini!</a>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection