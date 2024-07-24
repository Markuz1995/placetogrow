<?php

namespace App\Domains\user\Services;

use App\Constants\Constants;
use App\Domains\user\Models\user;
use App\Domains\user\Repositories\userRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(): LengthAwarePaginator
    {
        Log::info('Fetching all Users');
        return Cache::remember('Users', 60, function () {
            return $this->userRepository->paginate(Constants::RECORDS_PER_PAGE);
        });
    }

    public function getUserById(int $id): ?user
    {
        Log::info("Fetching user with id: {$id}");
        return Cache::remember("user_{$id}", 60, function () use ($id) {
            return $this->userRepository->find($id);
        });
    }

    public function createUser(array $data): user
    {
        Log::info('Creating a new user', ['data' => $data]);
        return $this->userRepository->create($data);
    }

    public function updateUser(int $id, array $data): bool
    {
        Log::info("Updating user with id: {$id}", ['data' => $data]);
        return $this->userRepository->update($id, $data);
    }

    public function deleteUser(int $id): bool
    {
        Log::info("Deleting user with id: {$id}");
        return $this->userRepository->delete($id);
    }
}
