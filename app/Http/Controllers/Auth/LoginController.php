<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'nik' => ['required', 'integer'],
            'password' => ['required', 'string'],
        ]);

        // Cari pengguna berdasarkan NIK
        $user = User::where('nik', $request->nik)->first();

        // Periksa apakah pengguna ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Login pengguna
            Auth::login($user, $request->filled('remember'));
            
            // Arahkan ke halaman yang diinginkan
            return redirect()->intended('mainMenu');
        }

        // Jika login gagal, kirim pesan kesalahan
        throw ValidationException::withMessages([
            'nik' => 'NIK atau password yang Anda masukkan salah.',
        ]);
    }
}
