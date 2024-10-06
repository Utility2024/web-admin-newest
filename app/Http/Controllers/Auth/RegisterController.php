<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    protected $redirectTo = '/mainMenu';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi NIK terlebih dahulu
        if (!$this->validateNik($request->nik)) {
            return redirect()->back()
                ->withErrors(['nik' => 'NIK tidak ditemukan atau tidak terdaftar, harap hubungi Human Resource (HR).'])
                ->withInput();
        }

        // Lanjutkan dengan validasi lainnya
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buat user baru dan login
        $user = $this->create($request->all());
        auth()->login($user);

        return redirect($this->redirectTo);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nik' => ['required', 'integer'], // Tidak perlu validasi unique:users di sini karena sudah divalidasi di validateNik()
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.unique' => 'Email sudah terdaftar.',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'nik' => $data['nik'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function validateNik($nik)
    {
        // Cek apakah NIK ada di tabel Employee (karyawan)
        return Employee::where('user_login', $nik)->exists();
    }
}
