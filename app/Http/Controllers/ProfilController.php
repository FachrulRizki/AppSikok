<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('profil.index', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'password_sekarang' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (Hash::check($request->password_sekarang, $user->password)) {
            $user->password = bcrypt(($request->password));
            $user->save();
            return redirect()->route('profile.index')->with('success', 'Password berhasil diperbarui');
        } else {
            return redirect()->route('profile.index')->with('error', 'Password sekarang salah!');
        }
    }
}
