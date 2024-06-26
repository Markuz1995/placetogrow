<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domains\Category\Models\Category;
use App\Domains\Category\Repositories\CategoryRepository;
use Illuminate\Support\Collection;

class CategoryRepositoryEloquent implements CategoryRepository
{
    public function all(): Collection
    {
        return Category::all();
    }

    public function find(int $id): ?Category
    {
        return Category::find($id);
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $category = $this->find($id);
        return $category ? $category->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $category = $this->find($id);
        return $category ? $category->delete() : false;
    }
}
