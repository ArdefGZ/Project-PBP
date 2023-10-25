<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Petugas;

class SessionController extends Controller
{
    function index()
    {
        return view("sesi.index");
    }

    function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $petugas = Petugas::all();

        foreach ($petugas as $user) {
            if ($user->email == $email && $user->password == $password) {
                // Authentication successful
                Session::flash("email", $email);
                return redirect('/dashboard');
            }
        }

        // Authentication failed
        return "Username atau password salah";
    }
}


// $request->validate([
//     "email" => "required",
//     "password" => "required"
// ], [
//     'email.required' => 'Email harus diisi',
//     'password.required' => 'Password harus diisi'
// ]);

// $infologin = [
//     'email' => strtolower($request->input('email')),
//     'password' => $request->input('password')
// ];        

// if(Auth::attempt($infologin)){
//     Session::flash("email", $request->input('email'));
//     return redirect('/dashboard');
// } else {
//     // Jika gagal
//     return "Gagal";
// }
