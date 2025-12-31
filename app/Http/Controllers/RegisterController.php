<?php

namespace App\Http\Controllers;

use App\Mail\Register;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    //
    const title = 'Register - dr. Em';

    public function index()
    {
        # code...
        return view('auth.register', [
            'title' => self::title
        ]);
    }
    public function register(Request $request)
    {
        $valid =  $request->validate([
            'name' => 'required',
            'birthday' => 'required',
            'address' => 'required',
            'email' => 'email|unique:users|required',
            'telp' => 'numeric|required',
            'password' => 'min:8|required',
            'password_confirmation' => 'min:8|required|same:password'

        ]);
        $valid['password'] = bcrypt($request['password']);
        User::create($valid);
        $isi_email = [
            'name' => $request->input('name'),
            'birthday' => $request->input('birthday'),
            'address' => $request->input('address'),
            'email' => $request->input('email'),
            'telp' => $request->input('telp'),
            'password' => 'Password Anda',
        ];

        $tujuan = $request->get('email');
        Mail::to($tujuan)->send(new Register($isi_email));
        return view('auth.login', [
            'registberhasil' => 'true',
            'email' => $valid['email'],
            'title' => 'dr. Em - Specialist Penyakit Cinta'

        ]);
    }
}
