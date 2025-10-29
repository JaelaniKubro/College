<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showSignupForm()
    {
        return view('signup');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:4',
            'role' => 'required'
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('dashboard.seller')->with('success', 'Akun berhasil dibuat!');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
            ]);

            if ($user->role === 'seller') {
                return redirect()->route('dashboard.seller');
            } elseif ($user->role === 'buyer') {
                return redirect()->route('home');
            }
        }

        return back()->with('error', 'Nama pengguna atau kata sandi salah.');
    }
}
