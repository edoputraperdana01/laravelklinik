<?php

namespace App\Http\Controllers;

use File;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    const title = 'Profil - dr. Em';

    // --- PERBAIKAN UTAMA ADA DI SINI ---
    public function profile()
    {
        // Sebelumnya: view('pasien.profile') -> Salah karena nama file 'profilepasien.blade.php'
        // Perbaikan:
        return view('pasien.profilepasien', [
            'title' => self::title
        ]);
    }

    public function profiledokter()
    {
        return view('dokter.profiledokter', [
            'title' => self::title
        ]);
    }

    public function profilestaff()
    {
        return view('staff.profilestaff', [
            'title' => self::title
        ]);
    }

    public function updateprofilepicture(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::find(Auth::id());

        // Hapus foto lama jika ada
        if ($user->image && file_exists(public_path('images/' . $user->image))) {
            unlink(public_path('images/' . $user->image));
        }

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        $user->image = $imageName;
        $user->save();

        return back()->with('success', 'Foto Profil Berhasil di Update');
    }

    public function hapusfoto()
    {
        $user = User::find(Auth::id());

        if ($user->image && file_exists(public_path('images/' . $user->image))) {
            unlink(public_path('images/' . $user->image));
            $user->image = null;
            $user->save();
            return back()->withSuccess('Foto berhasil dihapus');
        } else {
            return back()->withFail('Maaf foto sudah terhapus atau tidak ada');
        }
    }

    public function updatedokter(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'address' => 'required|string|max:255',
            'telp' => 'required|numeric',
            // Perbaikan Validasi Email: Mengabaikan ID user yang sedang login
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:5|required_with:current_password',
            'password_confirmation' => 'nullable|same:new_password'
        ]);

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->birthday = $request->birthday;
        $user->address = $request->address;
        $user->telp = $request->telp;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                return redirect()->back()->withInput()->withErrors(['current_password' => 'Password lama salah']);
            }
        }

        $user->save();
        return redirect()->route('profile-dokter')->withSuccess('Profil berhasil diperbarui');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'address' => 'required|string|max:255',
            'telp' => 'required|numeric',
            // Perbaikan Validasi Email
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:5|required_with:current_password',
            'password_confirmation' => 'nullable|same:new_password'
        ]);

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->birthday = $request->birthday;
        $user->address = $request->address;
        $user->telp = $request->telp;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                return redirect()->back()->withInput()->with('fail', 'Password lama tidak sesuai');
            }
        }

        $user->save();
        return redirect()->route('profile')->withSuccess('Profil berhasil diperbarui');
    }

    public function updatestaff(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'address' => 'required|string|max:255',
            'telp' => 'required|numeric',
            // Perbaikan Validasi Email
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:5|required_with:current_password',
            'password_confirmation' => 'nullable|same:new_password'
        ]);

        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->birthday = $request->birthday;
        $user->address = $request->address;
        $user->telp = $request->telp;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
            } else {
                return redirect()->back()->withInput()->withErrors(['current_password' => 'Password lama salah']);
            }
        }

        $user->save();
        return redirect()->route('profile-staff')->withSuccess('Profil berhasil diperbarui');
    }
}