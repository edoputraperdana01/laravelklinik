@extends('maintemplatedashboard')
@section('content')
@extends('partials.sidebar')
{{-- @section('search')
<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
    <div class="input-group">
        <input type="search" id="search" class="form-control bg-light border-1 small rounded-3" placeholder="Pencarian untuk..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
        </div>
    </div>
</form>
@endsection

@section('searchm')
<li class="nav-item dropdown no-arrow d-sm-none">
    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-search fa-fw"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
        <form class="form-inline mr-auto w-100 navbar-search">
            <div class="input-group">
                <input type="searchm" id="searchm" class="form-control bg-light border-0 small" placeholder="Pencarian untuk..." aria-label="Search" aria-describedby="basic-addon2">
            </div>
        </form>
    </div>
</li>
@endsection --}}
<div class="container-fluid">
<div class="card shadow">
        <div class="card-header"><h5 class="text-primary m-0 fw-bold">Jadwal</h5></div>
        <div class="card-body">
            <div class="table-responsive table " id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Jam Masuk</th>
                        <th class="text-center">Jam Pulang</th>
                        <th class="text-center">Status Masuk</th>
                        <th class="text-center">Jumlah Tersedia</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody id="old" > @php $no = 0; @endphp
                    @foreach ($jadwal as $item)
                    <tr >
                        @php $no++ @endphp
                        <td class="text-center align-middle">{{ $no }}</td>
                        <td class="text-center align-middle">{{  date('d M Y', strtotime($item->tgl_jadwal)) }}</td>
                        <td class="text-center align-middle">{{ $item->jam_masuk }}</td>
                        <td class="text-center align-middle">{{ $item->jam_pulang }}</td>
                        @if ($item->status_masuk ==0 )
                        <td class="text-center align-middle">Tidak Hadir</td>
                        @endif
                        @if ($item->status_masuk ==1)
                        <td class="text-center align-middle">Hadir</td>
                        @endif
                       <td class="text-center align-middle">{{ $item->jumlah_maxpasien }}</td>
                       <td class="text-center align-middle">
                        @if ($item->jumlah_maxpasien<1)
                         <i title="Tidak tersedia" class="bi bi-x-circle-fill text-danger"></i>
                    @else

                    <a  title="Buat Reservasi" data-bs-toggle="modal" data-bs-target="#buat-jadwal{{ $no }}" class="nav-link"><i class="fa-solid fa-calendar-plus"></i></a></h3>
                    <div class="modal fade" id="buat-jadwal{{ $no }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Buat Reservasi</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/reservasi" method="POST">
                                    @csrf
                                    <input type="hidden"  name="tglReservasi"  value="{{ $item->tgl_jadwal }}">
                                    <input type="hidden" name="idJadwal" value="{{ $item->id_jadwal }}">
                                    <div class="row d-flex align-items-center justify-content-between">
                                    <div class="col-md-5 text-left h6">Nama Pasien</div>
                                    <div class="col-lg-7">
                                        <input required class="form-control form-control-sm" type="text" name="namaPasien"  @if (session()->has('namaPasien') )value= "{{ session('namaPasien') }}" @endif id="nama" placeholder="Nama Pasien"></div>
                                </div>
                                <div class="row mt-3 d-flex align-items-center justify-content-between">
                                    <div class="col-md-5 text-left h6">Tanggal Periksa</div>
                                    <div class="col-lg-7">
                                        <input required class="form-control form-control-sm"  value="{{ $item->tgl_jadwal }}"  type="text" placeholder="{{ __('Tanggal Reservasi') }}" disabled>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-5 text-left h6">Keluhan</div>
                                    <div class="col-lg-7">
                                        <textarea required class="form-control form-control-sm" name="keluhan" placeholder="Masukan Keluhan Anda">{{ session('keluhan') }}</textarea>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center">

                                    <div class="col-7 col-md-5 mt-3">
                                        <button type="submit" class="btn bg-primary text-white col">Kirim</button>
                                    </form>
                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                            @endif
                       </td>

                        @endforeach
                </tbody>
                <tbody id="new">

                </tbody>
            </table>
        </div>
            </div>
            </div>



@endsection