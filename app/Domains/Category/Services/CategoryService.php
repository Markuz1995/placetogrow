<?php

namespace App\Domains\Category\Services;

use App\Constants\Constants;
use App\Domains\Category\Models\Category;
use App\Domains\Category\Repositories\CategoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(): LengthAwarePaginator
    {
        Log::info('Fetching all categories');
        return Cache::remember('categories', 60, function () {
            return $this->categoryRepository->paginate(Constants::RECORDS_PER_PAGE);
        });
    }

    public function getCategoryById(int $id): ?Category
    {
        Log::info("Fetching category with id: {$id}");
        return Cache::remember("category_{$id}", 60, function () use ($id) {
            return $this->categoryRepository->find($id);
        });
    }

    public function createCategory(array $data): Category
    {
        Log::info('Creating a new category', ['data' => $data]);
        return $this->categoryRepository->create($data);
    }

    public function updateCategory(int $id, array $data): bool
    {
        Log::info("Updating category with id: {$id}", ['data' => $data]);
        return $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory(int $id): bool
    {
        Log::info("Deleting category with id: {$id}");
        return $this->categoryRepository->delete($id);
    }

    public function getDataForSelect()
    {
        return Cache::remember('getDataForSelect', 60, function () {
            return $this->categoryRepository->getDataForSelect();
        });
    }
}
