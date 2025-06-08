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
        return Role::create($request->all());
    }

    public function hapusGroup($id)
    {   
        $role = $this->getGroup($id);
        return $role->delete();
    }

    public function getGroup($id)
    {
        return Role::findOrFail($id);
    }

    public function updateGroup($role, Request $request)
    {
        $permissionsIds = $request->input('permissions', []);

        return $role->syncPermissions($permissionsIds);
    }
}
