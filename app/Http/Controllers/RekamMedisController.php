<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\rekam_medis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    const title = 'Rekam Medis - dr. Em';
    public function rekammedis()
    {

        $rekam = rekam_medis::latest()->where('user_id', Auth::user()->id)->paginate(10);
        return view('pasien.rekammedis', [
            'title' => 'Riwayat Pemeriksaan',
            'rekam'  => $rekam

        ]);
    }

    public function tambahrekammedisdokter(Request $req)
    {
        if($req->nama_user != null){
            $req->validate(['nama_user' => 'required']);
        $data = [
            'user_id' => request('nama_user'),
            'nama_pasien' => request('nama_pasien'),
            'usia' => request('usia'),
            "tgl_periksa" => request("tgl_periksa"),
            "nama_penyakit" => request("nama_penyakit"),
            "kadar_gula_darah" => request("kadar_gula_darah"),
            "kadar_kolesterol" => request("kadar_kolesterol"),
            "kadar_asam_urat" => request("kadar_asam_urat"),
            "tekanan_darah" => request("tekanan_darah"),
            "alergi_makanan" => request("alergi_makanan"),
            "keterangan" => request("keterangan")
        ];
        if ($data['kadar_gula_darah'] == null) {
            $data['kadar_gula_darah'] = 0;
        };
        if ($data['kadar_asam_urat'] == null) {
            $data['kadar_asam_urat'] = 0;
        };
        if ($data['kadar_kolesterol'] == null) {
            $data['kadar_kolesterol'] = 0;
        };
        if ($data['alergi_makanan'] == null) {
            $data['alergi_makanan'] = '-';
        };
        if ($data['tekanan_darah'] == null) {
            $data['tekanan_darah'] = '-';
        };
        if ($data['keterangan'] == null) {
            $data['keterangan'] = '-';
        };
        rekam_medis::create($data);
        return redirect('/lihat-rekam-medis')->withSuccess('Data berhasil ditambahkan');
        }

        $pasien = User::where('level', '0')->get();
        return view('dokter.tambahrekammedis', [
            'pasien' => $pasien,
            'title' => self::title

        ]);
    }
    public function lihatrekammedis()
    {
        // $rekam = rekam_medis::join('users', 'User_id', '=', 'users.id')
        //     ->orderBy('rekam_medis.tgl_periksa', 'desc')->select('rekam_medis.*', 'users.name')->paginate(5);
            $rekam = rekam_medis::with('user')->orderBy('created_at','desc')->paginate(10);
        return view('dokter.rekammedis', [
            'title' => self::title,
            'rekam'  => $rekam,

        ]);
    }
    public function hapusrekammedis()
    {
        rekam_medis::where('id_rekam_medis', request('id'))->delete();
        return back()->withSuccess('Rekam Medis berhasil dihapus');
    }
    public function kelolarekammedis()
    {
        // $rekam = rekam_medis::join('users', 'User_id', '=', 'users.id')
        //     ->orderBy('rekam_medis.tgl_periksa', 'desc')->select('rekam_medis.*', 'users.name')->paginate(5);
        $rekam = rekam_medis::with('user')->orderBy('created_at','desc')->paginate(10);
        return view('staff.kelolarekammedis', [
            'title' => self::title,
            'rekam'  => $rekam,

        ]);
    }

    public function editrekammedis()
    {
        DB::table('rekam_medis')
            ->where('id_rekam_medis', request('id_user'))
            ->update([
                'nama_pasien' => request('nama_pasien'),
                'usia' => request('usia'),
                "tgl_periksa" => request("tgl_periksa"),
                "nama_penyakit" => request("nama_penyakit"),
                "kadar_gula_darah" => request("kadar_gula_darah"),
                "kadar_kolesterol" => request("kadar_kolesterol"),
                "kadar_asam_urat" => request("kadar_asam_urat"),
                "tekanan_darah" => request("tekanan_darah"),
                "alergi_makanan" => request("alergi_makanan"),
                "keterangan" => request("keterangan")

            ]);
        return back()->withSuccess('Data berhasil diperbarui');
    }
    public function tambahrekammedispost(Request $req)
    {
        $req->validate(['nama_user' => 'required']);
        $data = [
            'user_id' => request('nama_user'),
            'nama_pasien' => request('nama_pasien'),
            'usia' => request('usia'),
            "tgl_periksa" => request("tgl_periksa"),
            "nama_penyakit" => request("nama_penyakit"),
            "kadar_gula_darah" => request("kadar_gula_darah"),
            "kadar_kolesterol" => request("kadar_kolesterol"),
            "kadar_asam_urat" => request("kadar_asam_urat"),
            "tekanan_darah" => request("tekanan_darah"),
            "alergi_makanan" => request("alergi_makanan"),
            "keterangan" => request("keterangan")
        ];
        if ($data['kadar_gula_darah'] == null) {
            $data['kadar_gula_darah'] = 0;
        };
        if ($data['kadar_asam_urat'] == null) {
            $data['kadar_asam_urat'] = 0;
        };
        if ($data['kadar_kolesterol'] == null) {
            $data['kadar_kolesterol'] = 0;
        };
        if ($data['alergi_makanan'] == null) {
            $data['alergi_makanan'] = '-';
        };
        if ($data['tekanan_darah'] == null) {
            $data['tekanan_darah'] = '-';
        };
        if ($data['keterangan'] == null) {
            $data['keterangan'] = '-';
        };
        rekam_medis::create($data);
        return redirect('/kelola-rekam-medis')->withSuccess('Data berhasil ditambahkan');
    }
    public function tambahrekammedis()
    {
        $pasien = User::where('level', '0')->get();
        return view('staff.tambahrekammedis', [
            'pasien' => $pasien,
            'title' => self::title

        ]);
    }
    public function carirekampasien()
    {
        if (request('data') == null) {
            return;
        }
        $data = rekam_medis::Where('nama_pasien', 'like', '%' . request('data') . '%')->get();
        $data = $data->where('user_id', auth::id());

        $no = 0;
        $output = [];
        foreach ($data as $item) {
            $no++;
            $output[$no-1] =
                '<tr>
            <td class="text-center">' . $no . '</td>
            <td class="text-center">' . $item->nama_pasien . '</td>
            <td class="text-center">' . date('d M Y', strtotime($item->tgl_periksa)) . '</td>
            <td class="text-center">dr Rey</td>
            </tr>';
        }
        return response($output);
    }

    public function carirekammedis()
    {
        if (request('data') == null) {
            return;
        }
        $rekam = rekam_medis::join('users', 'User_id', '=', 'users.id');

        $data = $rekam->Where('nama_pasien', 'like', '%' . request('data') . '%')
            ->orWhere('name', 'like', '%' . request('data') . '%')
            ->get();
        // $data = $data->where('', );


        $no = 0;
        $output = [];
        foreach ($data as $item) {
            $no++;
            $output[$no-1] = '<tr>
            <td class="text-center">' . $no . '</td>
            <td class="text-center">' . $item->nama_pasien . '</td>
            <td class="text-center">' . $item->name . '</td>
            <td class="text-center">' . date('d M Y', strtotime($item->tgl_periksa)) . '</td>
            <td class="text-center">
                <button class="btn btn-sm py-auto" data-bs-toggle="modal" data-bs-target="#edit_rekam_medis' . $item->id_rekam_medis . '"><i class="fa-solid fa-pen-to-square"></i></button>
                <button class="btn btn-sm py-auto" data-bs-toggle="modal" data-bs-target="#hapus_rekam_medis' . $item->id_rekam_medis . '"><i class="fa-solid fa-trash-can"></i></button>
            </td>

            <div>
            <div class="modal fade" id="hapus_rekam_medis' . $item->id_rekam_medis . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="hapus_rekam_medis' . $item->id_rekam_medis . '">Hapus Rekam Medis</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <p>Apakah Anda yakin untuk menghapus?</p>
                        </div>
                    <form action="/hapus-rekam-medis" method="POST">
                    ' . csrf_field() . '
                    <input type="hidden" name="id" value="' . $item->id_rekam_medis . '">
                        <div class="modal-footer">
                                <div class="col-4 ">
                                    <button type="submit" class="btn bg-danger text-white col">Ya yakin</button>
                                   </div>
                                   <div class="col-4">
                                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak jadi </button>
                                   </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        <div>
                <form action="/edit-rekam-medis" method="POST">
                ' . csrf_field() . '
                <input type="hidden" name="id_user" value="' . $item->id_rekam_medis . '">
                    <div class="modal fade" id="edit_rekam_medis' . $item->id_rekam_medis . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="edit_rekam_medis' . $item->id_rekam_medis . '">Keterangan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Nama Pasien</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" name="nama_pasien" class="form-control col-sm-12" value="{{ $item->nama_pasien }}" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Usia</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" name="usia" class="form-control col-sm-12" value="{{ $item->usia }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Nama Penyakit</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" name="nama_penyakit" class="form-control col-sm-12" value="{{ $item->nama_penyakit }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Kadar Asam Urat</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="number" name="kadar_asam_urat" class="form-control col-sm-12" value="{{ $item->kadar_asam_urat }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Tanggal Periksa</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" name="tgl_periksa" class="form-control col-sm-12" value="{{ $item->tgl_periksa}}" onclick="(this.type="date")">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Kadar gula darah</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="number" name="kadar_gula_darah" class="form-control col-sm-12" value="{{ $item->kadar_gula_darah }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Alergi Makanan</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" name="alergi_makanan" class="form-control col-sm-12" value="{{ $item->alergi_makanan}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>kadar kolesterol</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="number" name="kadar_kolesterol" class="form-control col-sm-12" value="{{ $item->kadar_kolesterol}}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Kadar Gula Darah</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" name="kadar_gula_darah" class="form-control col-sm-12" value="{{ $item->kadar_gula_darah}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Keterangan</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <textarea  class="form-control col-sm-12" name="keterangan">{{ $item->keterangan }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                            <div class="col-7 col-md-5 col-xl-5 mb-3 mt-3">
                                <button type="submit" class="btn bg-primary text-white col">Simpan Perubahan</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</tr>';
        }
        return response($output);
    }

    public function carirekammedisdokter()
    {
        if (request('data') == null) {
            return;
        }
        $rekam = rekam_medis::join('users', 'User_id', '=', 'users.id');

        $data = $rekam->Where('nama_pasien', 'like', '%' . request('data') . '%')
            ->orWhere('name', 'like', '%' . request('data') . '%')
            ->get();
        // $data = $data->where('', );


        $no = 0;
        $output = [];
        foreach ($data as $item) {
            $no++;
            $output[$no-1]= '<tr>
            <td class="text-center">' . $no . '</td>
            <td class="text-center">' . $item->nama_pasien . '</td>
            <td class="text-center">' . $item->name . '</td>
            <td class="text-center">' . date('d M Y', strtotime($item->tgl_periksa)) . '</td>
            <td class="text-center">
                <button class="btn btn-sm py-auto" data-bs-toggle="modal" data-bs-target="#edit_rekam_medis' . $item->id_rekam_medis . '"><i class="fa-solid fa-pen-to-square"></i></button>
                <button class="btn btn-sm py-auto" data-bs-toggle="modal" data-bs-target="#hapus_rekam_medis' . $item->id_rekam_medis . '"><i class="fa-solid fa-trash-can"></i></button>
            </td>

            <div class="modal fade" id="hapus_rekam_medis' . $item->id_rekam_medis . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="hapus_rekam_medis' . $item->id_rekam_medis . '">Hapus Rekam Medis</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin untuk menghapus?</p>
                    </div>
                    <form action="/hapus-rekam-medis" method="POST">
                    ' . csrf_field() . '
                            <input type="hidden" name="id" value="' . $item->id_rekam_medis . '">
                        <div class="modal-footer">
                                <div class="col-4 ">
                                    <button type="submit" class="btn bg-danger text-white col">Ya yakin</button>
                                   </div>
                                   <div class="col-4">
                                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak jadi </button>
                                   </div>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        <div>
            <div>
                <form action="/edit-rekam-medis" method="POST">
                ' . csrf_field() . '
                <input type="hidden" name="id_user" value="' . $item->id_rekam_medis . '">
                    <div class="modal fade" id="edit_rekam_medis' . $item->id_rekam_medis . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="edit_rekam_medis' . $item->id_rekam_medis . '">Keterangan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Nama Pasien</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" name="nama_pasien" class="form-control col-sm-12" value="{{ $item->nama_pasien }}" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Usia</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" name="usia" class="form-control col-sm-12" value="{{ $item->usia }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Nama Penyakit</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" name="nama_penyakit" class="form-control col-sm-12" value="{{ $item->nama_penyakit }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Kadar Asam Urat</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="number" name="kadar_asam_urat" class="form-control col-sm-12" value="{{ $item->kadar_asam_urat }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Tanggal Periksa</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" name="tgl_periksa" class="form-control col-sm-12" value="{{ $item->tgl_periksa}}" onclick="(this.type="date")">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Kadar gula darah</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="number" name="kadar_gula_darah" class="form-control col-sm-12" value="{{ $item->kadar_gula_darah }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Alergi Makanan</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" name="alergi_makanan" class="form-control col-sm-12" value="{{ $item->alergi_makanan}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>kadar kolesterol</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="number" name="kadar_kolesterol" class="form-control col-sm-12" value="{{ $item->kadar_kolesterol}}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Kadar Gula Darah</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="text" name="kadar_gula_darah" class="form-control col-sm-12" value="{{ $item->kadar_gula_darah}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="row mt-3">
                                        <div class="col-sm-10"><strong>Keterangan</strong></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <textarea  class="form-control col-sm-12" name="keterangan">{{ $item->keterangan }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                            <div class="col-7 col-md-5 col-xl-5 mb-3 mt-3">
                                <button type="submit" class="btn bg-primary text-white col">Simpan Perubahan</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</tr>';

        }
        return response($output);
    }
}
