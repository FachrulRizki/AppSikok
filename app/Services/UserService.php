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

        return $user->assignRole($request->role);
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

        return $user->save();
    }

    public function hapusUser(User $user)
    {
        return $user->delete();
    }
}
