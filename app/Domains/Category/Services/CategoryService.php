<?php

namespace App\Domains\Category\Services;

use App\Constants\Constants;
use App\Domains\Category\Models\Category;
use App\Domains\Category\Repositories\CategoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(): LengthAwarePaginator
    {
        return $this->categoryRepository->paginate(Constants::RECORDS_PER_PAGE);
    }

    public function getCategoryById(int $id): ?Category
    {
        return $this->categoryRepository->find($id);
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

    public function getDataForSelect()
    {
        return $this->categoryRepository->getDataForSelect();
    }
}
