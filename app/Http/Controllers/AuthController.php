<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle user login.
     */

    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $validate = $request->validate([
            'no_induk_karyawan' => 'required|string|max:255',
            'password'          => 'required|string|min:8',
        ]);

        $user = Users::where('no_induk_karyawan', $validate['no_induk_karyawan'])->first();
        if (!$user) {
            return back()->withErrors(['no_induk_karyawan' => 'User not found.']);
        }
        if (!$user->is_active) {
            return back()->withErrors(['no_induk_karyawan' => 'User is inactive.']);
        }
        if (Hash::check($validate['password'], $user->password)) {
            // **SINI yang wajib:**
            // Loginkan juga guard Laravel, agar `Auth::check()` menjadi true.
            Auth::login($user);

            // Selanjutnya kamu bisa tetap set session tambahan jika mau:
            session([
                'user_id'        => $user->id,
                'user_name'      => $user->nama,
                'user_role'      => $user->role_id,
                'user_role_name' => $user->role?->nama,
                'user_avatar'    => $user->avatar,
                'user_no_induk_karyawan' => $user->no_induk_karyawan,
            ]);

            return redirect()->route('patiens.index');
        }
        return back()->withErrors(['password' => 'Invalid password.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();             // logout guard Laravel
        $request->session()->flush(); // hapus session custom kamu juga
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
