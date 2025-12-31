@extends('maintemplatedashboard')
@section('content')
@extends('partials.sidebarstaff')

<body id="page-top">
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-4 order-lg-2">

            <div class="card shadow mb-4">
                <div class="text-center container mt-4">
                    @if(Auth::user()->image != null)
                    <img class="rounded-circle avatar image" style="height: 150px; width: 150px;" src="{{asset('/images/'.Auth::user()->image)}}">
                    @else
                    <figure class="rounded-circle avatar font-weight-bold" style="font-size: 50px; height: 150px; width: 150px;" data-initial="{{ strtoupper(Auth::user()->name[0]) }}"></figure>
                    @endif
                </div>
                <div class="row text-center mx-4 mt-3">
                    <div class="col-lg-6">
                        <form action="/upload-foto" method="POST" enctype="multipart/form-data">
                            @csrf
                                <input type="file" name="image" id="image" class="form-control" style="display:none;" onchange="form.submit()">
                                <button type="button" class="btn btn-primary">
                                    <label class="mb-0" for="image">Perbarui Profile</label>
                                </button>
                        </form>
                    </div>
                    <div class="col-lg-6">
                    <button type="button" class="btn btn-danger" id="buttonHapus">Hapus Profile</button>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h5 class="font-weight-bold">{{  Auth::user()->fullName }}</h5>
                                <p>Staff</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-8 order-lg-1">
            @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success')}}
                <button type="button" class="btn-close" style="height: 5px" data-bs-dismiss="alert" aria-label="Close"></button>

            </div>
            @endif
            @if(session()->has('fail'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('fail')}}
                <button type="button" class="btn-close" style="height: 5px" data-bs-dismiss="alert" aria-label="Close"></button>

            </div>
            @endif
            @if ($errors->any())
            <div class="alert  alert-danger border-left-danger alert-dismissible fade show" role="alert">
                <ul class="pl-4 my-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

            </div>
            @endif
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Akun Saya</h6>
                </div>

                <div class="card-body">

                    <form method="POST" action="/profile-staff" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                        <h6 class="heading-small text-muted mb-4">Informasi Pengguna</h6>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">Nama<span class="small text-danger"> *</span></label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Name" value="{{ old('name', Auth::user()->name) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="birthday">Tanggal Lahir<span class="small text-danger"> *</span></label>
                                        <input type="date" id="birthday" class="form-control" name="birthday" placeholder="hh/bb/tttt" value="{{ old('birthday', Auth::user()->birthday) }}">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="address">Alamat<span class="small text-danger"> *</span></label>
                                        <input type="text" id="address" class="form-control" name="address" placeholder="Address" value="{{ old('address', Auth::user()->address) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="telp">No Handphone<span class="small text-danger"> *</span></label>
                                        <input type="integer" id="telp" class="form-control" name="telp" placeholder="08" value="{{ old('telp', Auth::user()->telp) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Alamat Email<span class="small text-danger"> *</span></label>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="email@gmail.com" value="{{ old('email', Auth::user()->email) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="current_password">Password Sekarang</label>
                                        <input type="password" id="current_password" class="form-control" name="current_password" placeholder="Password Sekarang">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="new_password">Password Baru</label>
                                        <input type="password" id="new_password" class="form-control" name="new_password" placeholder="Password Baru">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="confirm_password">Konfirmasi Password</label>
                                        <input type="password" id="confirm_password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>



            </div>

        </div>

    </div>
</div>

<div class="modal fade" id="hapusFoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Foto</h5>
                <button class="closemodal close" type="button" >
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Apakah anda yakin untuk menghapus foto?.</div>
            <div class="modal-footer">
            <button class="btn btn-link closemodal" type="button" data-dismiss="modal">Tidak</button>
                <form  action="/hapus-foto" method="POST">
                    @csrf
                <button class="btn btn-danger" type="submit" >Iya, Saya yakin</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$('#buttonHapus').click(function (e) {
    $('#hapusFoto').modal('show');

});
$('.closemodal').click(function (e) {
    $('#hapusFoto').modal('hide');

});
</script>
@endsection
