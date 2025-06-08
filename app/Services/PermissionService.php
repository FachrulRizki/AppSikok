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
        return Permission::create($request->all());
    }

    public function updatePermission(Permission $permission, Request $request)
    {
        return $permission->update($request->all());
    }

    public function hapusPermission(Permission $permission)
    {
        return $permission->delete();
    }
}
