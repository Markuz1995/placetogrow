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
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->categoryService->createCategory($request->all());

        return redirect()->route('categories.index');
    }

    public function show(int $id)
    {
        $category = $this->categoryService->getCategoryById($id);
        return view('categories.show', compact('category'));
    }

    public function edit(int $id)
    {
        $category = $this->categoryService->getCategoryById($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $this->categoryService->updateCategory($id, $request->all());

        return redirect()->route('categories.index');
    }

    public function destroy(int $id)
    {
        $this->categoryService->deleteCategory($id);
        return redirect()->route('categories.index');
    }
}
