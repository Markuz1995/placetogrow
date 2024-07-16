<?php

namespace Tests\Unit\Domains\Services;

use App\Constants\Constants;
use App\Domains\Category\Models\Category;
use App\Domains\Category\Repositories\CategoryRepository;
use App\Domains\Category\Services\CategoryService;
use Database\Factories\CategoryFactory;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    protected $categoryRepositoryMock;

    protected $categoryService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryRepositoryMock = Mockery::mock(CategoryRepository::class);
        $this->categoryService = new CategoryService($this->categoryRepositoryMock);
    }

    public function testGetAllCategories()
    {
        $paginatorMock = Mockery::mock(LengthAwarePaginator::class);
        $this->categoryRepositoryMock->shouldReceive('paginate')
            ->with(Constants::RECORDS_PER_PAGE)
            ->once()
            ->andReturn($paginatorMock);

        $result = $this->categoryService->getAllCategories();
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    public function testGetCategoryById()
    {
        $categoryMock = Mockery::mock(Category::class);
        $this->categoryRepositoryMock->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturn($categoryMock);

        $result = $this->categoryService->getCategoryById(1);
        $this->assertInstanceOf(Category::class, $result);
    }

    public function testCreateCategory()
    {
        $data = ['name' => 'Test Category'];
        $categoryMock = Mockery::mock(Category::class);
        $this->categoryRepositoryMock->shouldReceive('create')
            ->with($data)
            ->once()
            ->andReturn($categoryMock);

        $result = $this->categoryService->createCategory($data);
        $this->assertInstanceOf(Category::class, $result);
    }

    public function testUpdateCategory()
    {
        $id = 1;
        $data = ['name' => 'Updated Category'];
        $this->categoryRepositoryMock->shouldReceive('update')
            ->with($id, $data)
            ->once()
            ->andReturn(true);

        $result = $this->categoryService->updateCategory($id, $data);
        $this->assertTrue($result);
    }

    public function testDeleteCategory()
    {
        $id = 1;
        $this->categoryRepositoryMock->shouldReceive('delete')
            ->with($id)
            ->once()
            ->andReturn(true);

        $result = $this->categoryService->deleteCategory($id);
        $this->assertTrue($result);
    }

    public function testGetDataForSelect()
    {
        $categories = CategoryFactory::new()->count(10)->create();
        $expectedData = $categories->pluck('name', 'id');

        $this->categoryRepositoryMock->shouldReceive('getDataForSelect')
            ->once()
            ->andReturn($expectedData);

        $result = $this->categoryService->getDataForSelect();

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $result);
        $this->assertEquals($expectedData, $result);
        $this->assertDatabaseCount('categories', 10);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
