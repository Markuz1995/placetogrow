<?php

namespace App\Infrastructure\Persistence;

use App\Domains\User\Models\User;
use App\Domains\User\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserRepositoryEloquent implements UserRepository
{
    public function all(): Collection
    {
        return User::all();
    }

    public function find(int $id): ?User
    {
        return User::with('roles')->find($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $user = $this->find($id);

        return $user->update($data);
    }

    public function delete(int $id): bool
    {
        $user = $this->find($id);

        return $user ? $user->delete() : false;
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return User::with('roles')->paginate($perPage);
    }
}
