<?php

namespace App\Services;

use App\Models\AktivitasKeperawatan;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionService
{
    public function listPermission()
    {
        return Permission::latest()->paginate(10);
    }

    public function simpanPermission(Request $request)
    {
        Permission::create($request->all());

        return activity()
            ->event('Buat Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Membuat Permission');
    }

    public function updatePermission(Permission $permission, Request $request)
    {
        $permission->update($request->all());

        return activity()
            ->event('Update Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Mengupdate Permission');
    }

    public function hapusPermission(Permission $permission)
    {
        $permission->delete();

        return activity()
            ->event('Hapus Data')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => request()->ip()])
            ->log('Menghapus Permission');
    }
}
