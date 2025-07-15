<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function listUser($request)
    {
        $search = $request->get('search');

        $data = User::with('roles');
        
        if ($search) {
            $data->where('unit', 'like', '%' . $search . '%');
        }

        return $data->latest()->paginate(10);;
    }

    public function simpanUser($request)
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'unit' => $request->unit
        ]);

        $user->assignRole($request->role);

        return activity()
            ->event('Buat Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Membuat Pengguna');
    }

    public function updateUser(User $user, $request)
    {
        $user->name = $request->name;
        $user->username = $request->username;
        $user->unit = $request->unit;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->syncRoles([$request->role]);

        $user->save();

        return activity()
            ->event('Update Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Mengupdate Pengguna');
    }

    public function hapusUser(User $user)
    {
        $user->delete();

        return activity()
            ->event('Hapus Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Menghapus Pengguna');
    }
}
