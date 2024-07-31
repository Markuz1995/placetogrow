<?php

namespace App\Http\Controllers;

use App\Domains\User\Services\UserService;
use App\Http\Requests\NewUserRequest;
use Inertia\Inertia;

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
        $roles = $this->userService->getAllRoles();
        return Inertia::render('Users/Create', ['roles' => $roles]);
    }

    public function store(NewUserRequest $request)
    {
        $validated = $request->validated();
        $user = $this->userService->createUser($validated);

        return redirect()->route('users.index')->with('success', 'User was created');
    }

    public function show(int $id)
    {
        $user = $this->userService->getUserById($id);
        return Inertia::render('Users/Show', ['user' => $user]);
    }

    public function edit(int $id)
    {
        $roles = $this->userService->getAllRoles();
        $user = $this->userService->getUserById($id);
        return Inertia::render('Users/Edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update(NewUserRequest $request, int $id)
    {
        $validated = $request->validated();
        $this->userService->updateUser($id, $validated);

        return redirect()->route('users.index')->with('success', 'User was updated');
    }

    public function destroy(int $id)
    {
        $this->userService->deleteUser($id);
        return redirect()->route('users.index')->with('success', 'User was deleted');
    }
}
