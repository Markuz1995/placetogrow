<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use App\Domains\Category\Services\CategoryService;
use App\Domains\Microsite\Services\MicrositeService;
use App\Http\Requests\MicrositeRequest;

class MicrositeController extends Controller
{
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

        return inertia('Microsite/Index', [
            'microsites' => $microsites,
            'success' => session('success'),
        ]);
    }

    public function create()
    {
        $categories = $this->categoryService->getDataForSelect();
        $types = Constants::MICROSITE_TYPES;
        $currency = Constants::MICROSITE_CURRENCY;

        return inertia('Microsite/Create', [
            'categories' => $categories,
            'types' => $types,
            'currency' => $currency,
        ]);
    }

    public function store(MicrositeRequest $request)
    {
        $validated = $request->validated();
        $microsite = $this->micrositeService->createMicrosite($validated);

        return to_route('microsite.index', $microsite)->with('success', 'Microsite was created');
    }

    public function show(int $id)
    {
        $microsite = $this->micrositeService->getMicrositeById($id);

        return inertia('Microsite/Show', ['microsite' => $microsite]);
    }

    public function edit(int $id)
    {
        $microsite = $this->micrositeService->getMicrositeById($id);
        $categories = $this->categoryService->getDataForSelect();
        $types = Constants::MICROSITE_TYPES;
        $currency = Constants::MICROSITE_CURRENCY;

        return inertia('Microsite/Edit', [
            'microsite' => $microsite,
            'categories' => $categories,
            'types' => $types,
            'currency' => $currency,
        ]);
    }

    public function update(MicrositeRequest $request, int $id)
    {
        $validated = $request->validated();
        $this->micrositeService->updateMicrosite($id, $validated);

        return to_route('microsite.index')->with('success', 'Microsite was updated');
    }

    public function destroy(int $id)
    {
        $this->micrositeService->deleteMicrosite($id);

        return to_route('microsite.index')->with('success', 'Microsite was deleted');
    }
}
