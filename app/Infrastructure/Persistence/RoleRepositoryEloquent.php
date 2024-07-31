<?php

namespace App\Infrastructure\Persistence;

use App\Domains\Role\Repositories\RoleRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class RoleRepositoryEloquent implements RoleRepository
{
    public function all(): Collection
    {
        return Role::all();
    }

    public function find(int $id): ?Role
    {
        return Role::find($id);
    }

    public function create(array $data): Role
    {
        return Role::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $role = $this->find($id);

        return $role->update($data);
    }

    public function delete(int $id): bool
    {
        $role = $this->find($id);

        return $role ? $role->delete() : false;
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Role::paginate($perPage);
    }
}
