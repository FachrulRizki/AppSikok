<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class AuthController extends Controller
{
    public function login()
    {
        return view('layouts.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            activity()
                ->event('Autentikasi')
                ->causedBy(auth()->user())
                ->withProperties(['ip' => request()->ip()])
                ->log('Melakukan login');

            return redirect()->route('dashboard');
        };

        return redirect()->back()->with('error', 'Username atau password salah');
    }

    public function logout(Request $request)
    {
        activity()
            ->event('Autentikasi')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Melakukan logout');

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->to(RouteServiceProvider::HOME);
    }
}
