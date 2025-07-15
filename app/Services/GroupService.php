<?php

namespace App\Services;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class GroupService
{
    public function listGroup()
    {
        return Role::latest()->paginate(10);
    }

    public function simpanGroup(Request $request)
    {
        Role::create($request->all());

        return activity()
            ->event('Buat Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Membuat Group');
    }

    public function hapusGroup($id)
    {   
        $role = $this->getGroup($id);
        $role->delete();

        return activity()
            ->event('Hapus Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Menghapus Group');
    }

    public function getGroup($id)
    {
        return Role::findOrFail($id);
    }

    public function updateGroup($role, Request $request)
    {
        $permissionsIds = $request->input('permissions', []);

        $role->syncPermissions($permissionsIds);

        return activity()
            ->event('Update Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Mengupdate Group');
    }
}
