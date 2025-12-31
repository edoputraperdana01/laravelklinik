<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use DB;
use Hash;

class LupaPasswordController extends Controller
{
    const title = 'Lupa Password - dr. Em';
    public function lupapassword()
      {
         return view('auth.lupapassword', [
            'title' => self::title
        ]);
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function createtokenpassword(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
          ]);

          $token = Str::random(64);

          DB::table('password_resets')->insert([
              'email' => $request->email,
              'token' => $token,
              'created_at' => now()
            ]);

          Mail::send('mail.lupapassword', ['token' => $token], function($message) use($request){
              $message->to($request->email);
              $message->subject('Reset Password');
          });

          return back()->with('message', 'Kami telah mengirim email tautan reset kata sandi Anda!');
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function resetpassword($token) {
         return view('auth.lupapasswordform', [
            'token' => $token,
            'title' => self::title
        ]);
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function kirimresetpassword(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);

          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email,
                                'token' => $request->token
                              ])
                              ->first();

          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }

          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);

          DB::table('password_resets')->where(['email'=> $request->email])->delete();

          return redirect('/login')->with('message', 'Kata sandi Anda telah diubah!');
      }
}
