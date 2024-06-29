<?php

namespace App\Http\Controllers;

use App\Domains\Category\Services\CategoryService;
use App\Domains\Microsite\Services\MicrositeService;
use Illuminate\Http\Request;

class MicrositeController extends Controller
{
    private $validateString = 'required|string|max:255';
    protected $micrositeService;

    protected $categoryService;

    public function __construct(MicrositeService $micrositeService, CategoryService $categoryService)
    {
        $this->micrositeService = $micrositeService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $microsites = $this->micrositeService->getAllMicrosites();

        return view('microsites.index', compact('microsites'));
    }

    public function create()
    {
        $categories = $this->categoryService->getAllCategories();

        return view('microsites.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => $this->validateString,
            'logo' => $this->validateString,
            'category_id' => 'required|integer|exists:categories,id',
            'currency' => 'required|string|max:3',
            'expiration_time' => 'required|date_format:H:i:s',
            'type' => 'required|string|in:invoice,subscription,donation',
        ]);

        $this->micrositeService->createMicrosite($request->all());

        return redirect()->route('microsites.index');
    }

    public function show(int $id)
    {
        $microsite = $this->micrositeService->getMicrositeById($id);

        return view('microsites.show', compact('microsite'));
    }

    public function edit(int $id)
    {
        $microsite = $this->micrositeService->getMicrositeById($id);
        $categories = $this->categoryService->getAllCategories();

        return view('microsites.edit', compact('microsite', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => $this->validateString,
            'logo' => $this->validateString,
            'category_id' => 'required|integer|exists:categories,id',
            'currency' => 'required|string|max:3',
            'expiration_time' => 'required|date_format:H:i:s',
            'type' => 'required|string|in:invoice,subscription,donation',
        ]);

        $this->micrositeService->updateMicrosite($id, $request->all());

        return redirect()->route('microsites.index');
    }

    public function destroy(int $id)
    {
        $this->micrositeService->deleteMicrosite($id);

        return redirect()->route('microsites.index');
    }
}
