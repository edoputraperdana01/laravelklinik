<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    //
    const title = 'Login - dr. Em';

    public function index()
    {
        return view('auth.login', [
            'title' => self::title
        ]);
    }
    // public function indexstaff()
    // {
    //     return view('auth.loginstaff', [
    //         'title' => self::title
    //     ]);
    // }
    // public function indexstafflogin(Request $req)
    // {

    //     $data = $req->validate([
    //         'email' => 'email|required',
    //         'password' => 'required'
    //     ]);

    //     $email = $data['email'];
    //     $password = $data['password'];

    //     if (Auth::attempt(array('email' => $email, 'password' => $password, 'level' => 1))) {
    //         $req->session()->regenerate();
    //         return redirect('/dashboard-staff');
    //     }
    //     return back()->with('salah', 'Silahkan cek kembali email atau password anda')->with('email', $email);
    // }
    public function login(Request $req)
    {

        $data = $req->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $email = $data['email'];
        $password = $data['password'];

        if (Auth::attempt(array('email' => $email, 'password' => $password, 'level' => 0))) {
            $req->session()->regenerate();
            return redirect('/dashboard');
        }else if (Auth::attempt(array('email' => $email, 'password' => $password, 'level' => 1))) {
            $req->session()->regenerate();
            return redirect('/dashboard-staff');
        }else if (Auth::attempt(array('email' => $email, 'password' => $password, 'level' => 2))) {
            $req->session()->regenerate();
            return redirect('/dashboard-dokter');
        }
      
        return back()->with('salah', 'Silahkan cek kembali email atau password anda')->with('email', $email);
    }
    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/');
    }
  
}
