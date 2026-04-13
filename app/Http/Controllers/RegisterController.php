<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() {
        return view('registration');
    }

    public function store(Request $request) {
      $validated = $request->validate([
    'name' => 'required|max:255',
    'email' => [
        'required',
        'email',
        'unique:users,email',
        'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
    ],
    'password' => 'required|min:8|max:255',
    'telepon' => 'required|max:15'
], [
    'email.regex' => 'Email harus menggunakan @gmail.com',
    'email.unique' => 'Email sudah terdaftar',
    'email.email' => 'Format email tidak valid'
]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect(route('home'))->with('registrasi', 'Registrasi Berhasil, Silakan login untuk mulai menyewa');
    }
}
