<?php

namespace App\Domains\Microsite\Repositories;

use App\Domains\Microsite\Models\Microsite;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface MicrositeRepository
{
    public function all(): Collection;

    public function find(int $id): ?Microsite;

    public function create(array $data): Microsite;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function paginate(int $perPage): LengthAwarePaginator;
}
