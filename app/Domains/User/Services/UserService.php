<?php

namespace App\Domains\User\Services;

use App\Constants\Constants;
use App\Domains\User\Models\User;
use App\Domains\User\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(): LengthAwarePaginator
    {
        Log::info('Fetching all users');
        return $this->userRepository->paginate(Constants::RECORDS_PER_PAGE);
    }

    public function getUserById(int $id): ?User
    {
        Log::info("Fetching user with id: {$id}");
        return $this->userRepository->find($id);
    }

    public function createUser(array $data): User
    {
        Log::info('Creating a new user', ['data' => $data]);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user = $this->userRepository->create($data);
        $user->assignRole($data['roles']);
        return $user;
    }

    public function updateUser(int $id, array $data): bool
    {
        Log::info("Updating user with id: {$id}", ['data' => $data]);
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $updated = $this->userRepository->update($id, $data);

        if ($updated) {
            $user = $this->getUserById($id);
            $user->syncRoles($data['roles']);
        }

        return $updated;
    }

    public function deleteUser(int $id): bool
    {
        Log::info("Deleting user with id: {$id}");
        return $this->userRepository->delete($id);
    }

    public function getAllRoles()
    {
        return Role::all();
    }
}
