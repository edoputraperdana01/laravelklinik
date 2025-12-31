<?php

namespace App\Http\Controllers;

use App\Models\jadwal;
use App\Models\reservasi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservasiController extends Controller
{
    const title = 'Reservasi - dr. Em';

    public function index()
    {
        //
    }

    // --- [BARU] HALAMAN FORM RESERVASI ---
    public function halamanBuatReservasi()
    {
        return view('pasien.buat_reservasi', [
            'title' => 'Buat Reservasi Baru',
            'status_cek' => null 
        ]);
    }

    // --- [BARU] LOGIKA CEK KETERSEDIAAN JADWAL ---
    public function cekJadwal(Request $req)
    {
        $req->validate(['tgl_reservasi' => 'required|date']);

        // Cari jadwal di tanggal tersebut
        $jadwal = jadwal::where('tgl_jadwal', $req->tgl_reservasi)->first();

        // Tentukan status: tersedia, penuh, atau tidak_ada
        $status = 'tidak_ada';
        if($jadwal) {
            if($jadwal->jumlah_maxpasien > 0) {
                $status = 'tersedia';
            } else {
                $status = 'penuh';
            }
        }

        return view('pasien.buat_reservasi', [
            'title' => 'Buat Reservasi Baru',
            'status_cek' => $status,
            'tanggal_dipilih' => $req->tgl_reservasi,
            'data_jadwal' => $jadwal 
        ]);
    }

    // --- [UPDATE] PROSES SIMPAN RESERVASI (DENGAN BLACKLIST & RULES) ---
    public function createreservasipost(Request $req)
    {
        $iduser = Auth::user()->id;
        $tanggalReservasi = $req['tglReservasi'];

        // 1. CEK BLACKLIST: Apakah user sering mangkir (status 2)?
        $jumlahMangkir = reservasi::where('user_id', $iduser)
                                  ->where('status_hadir', 2) 
                                  ->count();

        // Jika sudah 3 kali atau lebih mangkir, tolak reservasi
        if ($jumlahMangkir >= 3) {
            return redirect('/buat-reservasi')->with('salah', 'Akun Anda dibekukan sementara karena tercatat lebih dari 3 kali tidak hadir pada jadwal sebelumnya. Silakan hubungi admin.');
        }

        // 2. CEK DOUBLE BOOKING: 1 Pasien = 1 Reservasi per hari
        $sudahAda = reservasi::where('user_id', $iduser)
                             ->where('tgl_reservasi', $tanggalReservasi)
                             ->exists();

        if ($sudahAda) {
            return redirect('/buat-reservasi')->with('salah', 'Anda sudah memiliki jadwal reservasi di tanggal ini. Mohon datang tepat waktu.');
        }

        // 3. CEK KUOTA JADWAL
        $valid = jadwal::where('id_jadwal', $req['idJadwal'])->first();

        if ($valid->jumlah_maxpasien <= 0) {
            return redirect('/buat-reservasi')->with('salah', 'Mohon maaf, kuota antrian baru saja habis.');
        }

        // 4. HITUNG NOMOR ANTRIAN & SISA KUOTA
        $sisa_kuota = $valid->jumlah_maxpasien - 1;
        $no_antrian_baru = $valid->jumlah_pasien_hari_ini + 1;

        $data = [
            "nama_pasien" => $req['namaPasien'],
            'user_id' => $iduser,
            "tgl_reservasi" => $tanggalReservasi,
            "keluhan" => $req['keluhan'],
            "no_antrian" => $no_antrian_baru,
            "status_hadir" => 0 // Default: Belum Hadir
        ];

        // 5. UPDATE JADWAL & SIMPAN RESERVASI
        jadwal::where('id_jadwal', $req['idJadwal'])->update([
            'jumlah_maxpasien' => $sisa_kuota,
            'jumlah_pasien_hari_ini' => $no_antrian_baru
        ]);
        
        reservasi::create($data);

        return redirect('/reservasi')->with('Success', 'Reservasi Berhasil! Nomor Antrian Anda: ' . $no_antrian_baru);
    }

    // --- HALAMAN RIWAYAT RESERVASI PASIEN ---
    public function reservasi()
    {
        $reservasi = reservasi::orderBy('tgl_reservasi', 'desc')
                              ->where('user_id', Auth::user()->id)
                              ->paginate(10);

        return view('pasien.reservasi', [
            'title' => self::title,
            'reservasi' => $reservasi
        ]);
    }

    // --- FUNGSI PENCARIAN & HELPER (DARI KODE ASLI) ---

    public function carireservasidokter()
    {
        if(request('data')== null){ return; }
        $data = reservasi::where('nama_pasien', 'like', '%' . request('data') . '%')
            ->orWhere('tgl_reservasi', 'like', '%' . request('data') . '%')
            ->orWhere('keluhan', 'like', '%' . request('data') . '%')->get();

        $no = 0; $output = '';
        foreach ($data as $item) {
            $no++;
            $status = ($item->status_hadir == 0) ? 'Belum Hadir' : (($item->status_hadir == 1) ? 'Hadir' : 'Tidak Hadir');
            $output .= '<tr><td class="align-middle text-center">'.$no.'</td><td class="align-middle text-center">'.$item->nama_pasien.'</td><td class="align-middle text-center">'.date("d M Y", strtotime($item->tgl_reservasi)).'</td><td class="align-middle text-center">'.$item->keluhan.'</td><td class="align-middle text-center">'.$item->no_antrian.'</td><td class="align-middle text-center">'.$status.'</td></tr>';
        }
        return response($output);
    }

    public function carireservasi()
    {
        if(request('data')== null){ return; }
        $data = reservasi::where('nama_pasien', 'like', '%' . request('data') . '%')
            ->orWhere('tgl_reservasi', 'like', '%' . request('data') . '%')
            ->orWhere('keluhan', 'like', '%' . request('data') . '%')->get();

        $no = 0; $output = '';
        foreach ($data as $item) {
            $no++;
            $status = ($item->status_hadir == 0) ? 'Belum Hadir' : (($item->status_hadir == 1) ? 'Hadir' : 'Tidak Hadir');
            
            // Generate HTML Output untuk Tabel Admin/Staff
            $output .= '<tr>
                <td class="align-middle text-center">' . $no . '</td>
                <td class="align-middle">' . $item->nama_pasien . '</td>
                <td class="align-middle text-center">' .  date("d M Y", strtotime($item->tgl_reservasi)) . '</td>
                <td class="align-middle small">' . $item->keluhan . '</td>
                <td class="align-middle text-center">' . $item->no_antrian . '</td>
                <td class="align-middle text-center">
                    <form action="edit-reservasi" method="post" class="d-flex gap-1 justify-content-center">
                        '.csrf_field().'
                        <input type="hidden" name="id" value="' . $item->id_reservasi . '">
                        <input type="hidden" name="tgl" value="' . $item->tgl_reservasi . '">
                        <select name="status" class="form-select form-select-sm" style="width: 130px;">
                            <option value="0" '.($item->status_hadir==0?'selected':'').'>Belum Hadir</option>
                            <option value="1" '.($item->status_hadir==1?'selected':'').'>Hadir</option>
                            <option value="2" '.($item->status_hadir==2?'selected':'').'>Tidak Hadir</option>
                        </select>
                        <button title="Simpan" type="submit" class="btn btn-sm btn-primary"><i class="fa-solid fa-floppy-disk"></i></button>
                    </form>
                </td>
            </tr>';
        }
        return response($output);
    }

    public function carireservasipasien()
    {
        if(request('data')==null){ return; }
        
        $data = reservasi::where('user_id', Auth::id())
            ->where(function($query) {
                $query->where('nama_pasien', 'like', '%' . request('data') . '%')
                      ->orWhere('tgl_reservasi', 'like', '%' . request('data') . '%')
                      ->orWhere('keluhan', 'like', '%' . request('data') . '%');
            })->get();

        $no = 0; $output = '';
        foreach ($data as $item) {
            $no++;
            $badge = '';
            if ($item->status_hadir == 0) $badge = '<span class="badge rounded-pill bg-warning text-dark px-3">Belum Hadir</span>';
            elseif ($item->status_hadir == 1) $badge = '<span class="badge rounded-pill bg-success px-3">Hadir</span>';
            else $badge = '<span class="badge rounded-pill bg-danger px-3">Tidak Hadir</span>';

            $output .= '<tr>
                <td class="text-center fw-bold text-secondary">'.$no.'</td>
                <td class="fw-bold text-dark">'.$item->nama_pasien.'</td>
                <td class="text-center"><span class="badge bg-light text-dark border">'.date("d M Y", strtotime($item->tgl_reservasi)).'</span></td>
                <td class="small text-muted">'.$item->keluhan.'</td>
                <td class="text-center"><span class="badge rounded-circle bg-primary">'.$item->no_antrian.'</span></td>
                <td class="text-center">'.$badge.'</td>
            </tr>';
        }
        return response($output);
    }

    public function kelolareservasi()
    {
        if (request('tanggal')==null) {
            $kelolareservasi = reservasi::orderBy('tgl_reservasi','desc')->orderBy('no_antrian')->paginate(10);
        }else{
            $kelolareservasi = reservasi::where('tgl_reservasi',request('tanggal'))->orderBy('no_antrian')->paginate(10);
        }
        return view('staff.kelolareservasi', [
            'reservasi' => $kelolareservasi,
            'title' => self::title
        ]);
    }

    public function lihatreservasi()
    {
        if (request('tanggal')==null) {
            $kelolareservasi = reservasi::orderBy('tgl_reservasi','desc')->orderBy('no_antrian')->paginate(10);
        }else{
            $kelolareservasi = reservasi::where('tgl_reservasi',request('tanggal'))->orderBy('no_antrian')->paginate(10);
        }
        return view('dokter.reservasi', [
            'reservasi' => $kelolareservasi,
            'title' => self::title
        ]);
    }

    public function editreservasi(Request $req)
    {
        // Logika Update Status & Kuota
        $reservasi = reservasi::where('id_reservasi', $req['id'])->first();
        
        // Jika status berubah DARI Hadir/Belum KE Tidak Hadir -> Kuota Tambah (Slot kosong)
        // Jika status berubah DARI Tidak Hadir KE Hadir/Belum -> Kuota Kurang (Slot terisi)
        // Note: Logika asli Anda dipertahankan, namun disederhanakan:
        
        $jadwal = jadwal::where('tgl_jadwal', $req['tgl'])->first();
        
        if ($reservasi->status_hadir != 2 && $req['status'] == 2) {
            // Pasien jadi "Tidak Hadir", kembalikan slot
            if($jadwal) jadwal::where('tgl_jadwal', $req['tgl'])->increment('jumlah_maxpasien');
        } 
        else if ($reservasi->status_hadir == 2 && $req['status'] != 2) {
            // Pasien dari "Tidak Hadir" jadi "Hadir/Belum", ambil slot
            if($jadwal) jadwal::where('tgl_jadwal', $req['tgl'])->decrement('jumlah_maxpasien');
        }

        reservasi::where('id_reservasi', $req['id'])->update(['status_hadir' => $req['status']]);
        return back()->withSuccess('Status reservasi berhasil diperbarui');
    }

    public function hapusreservasi(Request $req)
    {
        $reservasi = reservasi::where('id_reservasi', $req['id'])->first();
        if($reservasi){
            // Kembalikan kuota jika reservasi dihapus (kecuali jika statusnya memang sudah 'Tidak Hadir' yg kuotanya sudah dikembalikan)
            if($reservasi->status_hadir != 2) {
               jadwal::where('tgl_jadwal', $reservasi->tgl_reservasi)->increment('jumlah_maxpasien');
            }
            $reservasi->delete();
        }
        return back()->withSuccess('Data reservasi berhasil dihapus');
    }
}