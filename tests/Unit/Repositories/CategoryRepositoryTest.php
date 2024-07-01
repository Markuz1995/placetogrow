<?php

namespace Tests\Unit\Repositories;

use App\Domains\Category\Models\Category;
use App\Infrastructure\Persistence\CategoryRepositoryEloquent;
use Database\Factories\CategoryFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private CategoryRepositoryEloquent $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new CategoryRepositoryEloquent();
    }

    protected function createCategory(array $attributes = []): Category
    {
        return CategoryFactory::new()->create($attributes);
    }

    public function testCreateCategory()
    {
        $data = ['name' => 'Test Category'];

        $createdCategory = $this->repository->create($data);

        $this->assertInstanceOf(Category::class, $createdCategory);
        $this->assertEquals('Test Category', $createdCategory->name);
        $this->assertDatabaseHas('categories', $data);
    }

    public function testUpdateCategory()
    {
        $category = $this->createCategory(['name' => 'Old Name']);
        $newData = ['name' => 'New Name'];

        $result = $this->repository->update($category->id, $newData);

        $this->assertTrue($result);
        $this->assertEquals('New Name', $category->fresh()->name);
        $this->assertDatabaseHas('categories', $newData);
    }

    public function testFindCategory()
    {
        $category = $this->createCategory();

        $foundCategory = $this->repository->find($category->id);

        $this->assertInstanceOf(Category::class, $foundCategory);
        $this->assertEquals($category->name, $foundCategory->name);
    }

    public function testDeleteCategory()
    {
        $category = $this->createCategory();

        $result = $this->repository->delete($category->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function testPaginateCategories()
    {
        CategoryFactory::new()->count(10)->create();

        $paginatedCategories = $this->repository->paginate(5);

        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $paginatedCategories);
        $this->assertCount(5, $paginatedCategories->items());
        $this->assertEquals(10, $paginatedCategories->total());
    }

    public function testGetDataForSelect()
    {
        CategoryFactory::new()->count(5)->create();

        $data = $this->repository->getDataForSelect();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $data);
        $this->assertCount(5, $data);

        $data->each(function ($item) {
            $this->assertInstanceOf(Category::class, $item);
            $this->assertArrayHasKey('id', $item->getAttributes());
            $this->assertArrayHasKey('name', $item->getAttributes());
        });

        $this->assertEquals(5, $data->pluck('id')->unique()->count());
        $this->assertEquals(5, $data->pluck('name')->filter()->count());
    }
}
