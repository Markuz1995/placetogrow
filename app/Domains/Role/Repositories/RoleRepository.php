<?php

namespace App\Domains\Role\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

interface RoleRepository
{
    public function all(): Collection;

    public function find(int $id): ?Role;

    public function create(array $data): Role;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function paginate(int $perPage): LengthAwarePaginator;
}
