<?php

namespace App\Infrastructure\Persistence;

use App\Domains\Microsite\Models\Microsite;
use App\Domains\Microsite\Repositories\MicrositeRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MicrositeRepositoryEloquent implements MicrositeRepository
{
    public function all(): Collection
    {
        return Microsite::with('category')->get();
    }

    public function find(int $id): ?Microsite
    {
        return Microsite::with('category')->find($id);
    }

    public function create(array $data): Microsite
    {
        return Microsite::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $microsite = $this->find($id);

        return $microsite ? $microsite->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $microsite = $this->find($id);

        return $microsite ? $microsite->delete() : false;
    }

    public function paginate(int $perPage): LengthAwarePaginator
    {
        return Microsite::with('category')->paginate($perPage);
    }
}
