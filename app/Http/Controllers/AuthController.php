<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('produk.index');
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    // =========================
    // HALAMAN GANTI PASSWORD
    // =========================
    public function showGantiPassword()
    {
        return view('auth.ganti-password');
    }

    // =========================
    // UPDATE PASSWORD
    // =========================
    public function updatePassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password_lama' => 'required',
        'password_baru' => 'required|min:4',
    ]);

    // cari user berdasarkan email
    $user = \App\Models\User::where('email', $request->email)->first();

    // cek user ada atau tidak
    if (!$user) {
        return back()->with('error', 'Email tidak ditemukan');
    }

    // cek password lama
    if (!Hash::check($request->password_lama, $user->password)) {
        return back()->with('error', 'Password lama salah');
    }

    // update password baru
    $user->password = Hash::make($request->password_baru);
    $user->save();

    return back()->with('success', 'Password berhasil diubah');
}

}