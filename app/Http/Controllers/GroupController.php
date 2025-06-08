<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Services\GroupService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GroupController extends Controller
{
    protected $service;

    public function __construct(GroupService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->listGroup();

        return view('group.index', compact('data'));
    }

    public function store(GroupRequest $request)
    {
        $request->validated();
        $this->service->simpanGroup($request);

        return redirect()->route('groups.index')->with('success', 'Grup berhasil disimpan');
    }

    public function show($id)
    {
        $data = $this->service->getGroup($id);
        $permissions = Permission::all();
        return view('group.show', compact('data', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->service->getGroup($id);
        $this->service->updateGroup($data, $request);

        return redirect()->route('groups.show', $id)->with('success', 'Permission Grup berhasil diupdate');
    }

    public function destroy($id)
    {
        $this->service->hapusGroup($id);
        return redirect()->route('groups.index')->with('success', 'Grup berhasil dihapus');
    }
}
