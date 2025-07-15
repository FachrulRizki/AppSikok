<?php

namespace App\Http\Controllers;

use App\Services\ImageCompressorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

            activity()
                ->event('Update Data')
                ->causedBy(auth()->user())
                ->withProperties(['ip' => request()->ip()])
                ->log('Mengupdate Password');

            return redirect()->route('profile.index')->with('success', 'Password berhasil diperbarui');
        } else {
            return redirect()->route('profile.index')->with('error', 'Password sekarang salah!');
        }
    }

    public function fotoProfil(Request $request, ImageCompressorService $compressor)
    {
        $request->validate([
            'foto_profil' => 'required|image|max:2048|mimetypes:image/jpeg,image/png,image/webp',
        ]);

        $user = auth()->user();

        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $path = $compressor->compressAndUpload($request->file('foto_profil'), 'foto_profil')[0];

        $user->update([
            'foto_profil' => $path,
        ]);

        activity()
            ->event('Update Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Mengupdate Foto Profil');

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}
