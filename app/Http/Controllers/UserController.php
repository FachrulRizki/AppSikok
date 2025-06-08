<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $data = $this->service->listUser($request);

        return view('users.index', compact('data'));
    }

    public function create()
    {
        $route = route('users.store');
        $method = 'POST';
        $roles = Role::all();

        return view('users.create', compact('route', 'method', 'roles'));
    }

    public function store(UserRequest $request)
    {
        $request->validated();
        $this->service->simpanUser($request);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil disimpan');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('roles', 'user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $request->validated();
        $this->service->updateUser($user, $request);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $this->service->hapusUser($user);
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus');
    }
}
