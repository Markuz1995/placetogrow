<?php

namespace App\Http\Controllers;

use App\Domains\Category\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();

        return inertia('Category/Index', [
            'categories' => $categories,
            'success' => session('success'),
        ]);
    }

    public function create()
    {
        return inertia('Category/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30|unique:categories',
        ]);

        $category = $this->categoryService->createCategory($validated);

        return to_route('category.index', $category)->with('success', 'Category was created');
    }

    public function show(int $id)
    {
        $category = $this->categoryService->getCategoryById($id);

        return view('categories.show', compact('category'));
    }

    public function edit(int $id)
    {
        $category = $this->categoryService->getCategoryById($id);

        return inertia('Category/Edit', ['category' => $category]);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        $this->categoryService->updateCategory($id, $validated);

        return to_route('category.index')->with('success', 'Category was updated');
    }

    public function destroy(int $id)
    {
        $this->categoryService->deleteCategory($id);

        return to_route('category.index')->with('success', 'Category was deleted');
    }
}
