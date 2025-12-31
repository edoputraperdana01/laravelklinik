<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    const title = 'Pasien - dr. Em';
    public function kelolapasien()
    {
        $all = User::where('level','0')->paginate(10);
        return view('staff.kelolapasien',[
            'title' => self::title,
            'user'=>$all
        ]);
    }

    public function lihatpasien()
    {
        $all = User::where('level','0')->paginate(10);
        return view('dokter.pasien',[
            'title' => self::title,
            'user'=>$all
        ]);
    }

    public function caripasien()
    {
        if(request('data')== null){
            return;
        }
        $data = user::where('name', 'like', '%' . request('data') . '%')
            ->orWhere('birthday', 'like', '%' . request('data') . '%')
            ->orWhere('telp', 'like', '%' . request('data') . '%')
            ->orWhere('email', 'like', '%' . request('data') . '%')
            ->orWhere('address', 'like', '%' . request('data') . '%')->get();
        $data = $data->where('level',0);

        $no = 0;
        $output = '';
        foreach ($data as $item) {
            $no++;

            $output .= '<tr>
                                            <td class="text-center">' . $no . '</td>
                                            <td class="text-center">' . $item->name . '</td>
                                            <td class="text-center">' .  date("d M Y", strtotime($item->birthday)) . '</td>
                                            <td class="text-center">' . $item->address . '</td>
                                            <td class="text-center">' . $item->email . '</td>
                                            <td class="text-center">' . $item->telp . '</td>

                            </tr>';
        }
        return response($output);
    }
}
