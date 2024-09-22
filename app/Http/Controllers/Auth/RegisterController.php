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
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (!$this->validateNik($request->nik)) {
            return redirect()->back()
                ->withErrors(['nik' => 'NIK tidak ditemukan atau tidak terdaftar , harap hubungi Human Resource (HR).'])
                ->withInput();
        }

        $user = $this->create($request->all());
        auth()->login($user);

        return redirect($this->redirectTo);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nik' => ['required', 'integer', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nik.unique' => 'NIK sudah terdaftar.',
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
        return Employee::where('user_login', $nik)->exists();
    }

}
