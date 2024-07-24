<?php

namespace App\Domains\User\Repositories;

use App\Domains\User\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserRepository
{
    public function all(): Collection;

    public function find(int $id): ?User;

    public function create(array $data): User;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function paginate(int $perPage): LengthAwarePaginator;
}
