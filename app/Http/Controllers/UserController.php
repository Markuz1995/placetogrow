<?php

namespace App\Http\Controllers;

use App\Domains\user\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return Inertia::render('Users/Index', ['users' => $users]);
    }

    public function create()
    {
        $roles = Role::all(); //TODO: move to services
        return Inertia('Users/Create', ['roles' => $roles]);
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        $user = $this->userService->createUser($validated);
        $user->assignRole($request->roles);

        return to_route('users.index', $user)->with('success', 'User was created');
    }

    public function show(int $id)
    {
        $user = $this->userService->getUserById($id);
        return inertia('Users/Show', ['user' => $user]);
    }

    public function edit(int $id)
    {
        $roles = Role::all();
        $user = $this->userService->getUserById($id);
        return inertia('Users/Edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update(UserRequest $request, int $id)
    {

        $validated = $request->validated();
        $this->userService->updateUser($id, $validated);

        // if ($request->filled('password')) {
        //     $request->validate(['password' => 'confirmed|min:8']);
        //     $user->update(['password' => bcrypt($request->password)]);
        // }

        // $user->syncRoles($request->roles);
        return to_route('users.index')->with('success', 'User was updated');
    }

    public function destroy(int $id)
    {
        $this->userService->deleteUser($id);
        return to_route('users.index')->with('success', 'User was deleted');
    }
}
