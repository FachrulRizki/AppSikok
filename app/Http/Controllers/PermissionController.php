<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    protected $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $data = $this->service->listPermission($request);

        return view('permission.index', compact('data'));
    }

    public function store(PermissionRequest $request)
    {
        $request->validated();
        $this->service->simpanPermission($request);

        return redirect()->route('permissions.index')->with('success', 'Permission berhasil disimpan');
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $request->validated();
        $this->service->updatePermission($permission, $request);

        return redirect()->route('permissions.index')->with('success', 'Permission berhasil diperbarui');
    }

    public function destroy(Permission $permission)
    {
        $this->service->hapusPermission($permission);
        return redirect()->route('permissions.index')->with('success', 'Permission berhasil dihapus');
    }
}
