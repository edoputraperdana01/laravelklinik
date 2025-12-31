<?php

namespace App\Http\Controllers;

use App\Mail\Hubungi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function hubungi(Request $request){
        $isi_email = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message')
        ];

        $tujuan = User::where('level', '1')->get();
        Mail::to($tujuan)->send(new Hubungi($isi_email));
        return back()->withSuccess('Email Telah Terkirim');
    }

}
