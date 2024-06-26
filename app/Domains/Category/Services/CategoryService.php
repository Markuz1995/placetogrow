<?php

namespace App\Domains\Category\Services;

use App\Domains\Category\Repositories\CategoryRepository;
use App\Domains\Category\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->all();
    }

    public function getCategoryById(int $id): ?Category
    {
        return $this->categoryRepository.find($id);
    }

    public function createCategory(array $data): Category
    {
        return $this->categoryRepository->create($data);
    }

    public function updateCategory(int $id, array $data): bool
    {
        return $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory(int $id): bool
    {
        return $this->categoryRepository->delete($id);
    }
}
