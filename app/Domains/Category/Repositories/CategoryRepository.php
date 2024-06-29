<?php

namespace App\Domains\Category\Repositories;

use App\Domains\Category\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CategoryRepository
{
    public function all(): Collection;

    public function find(int $id): ?Category;

    public function create(array $data): Category;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function paginate(int $perPage): LengthAwarePaginator;
}
