<?php

namespace App\Domains\Microsite\Services;

use App\Constants\Constants;
use App\Domains\Microsite\Models\Microsite;
use App\Domains\Microsite\Repositories\MicrositeRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MicrositeService
{
    protected $micrositeRepository;

    public function __construct(MicrositeRepository $micrositeRepository)
    {
        $this->micrositeRepository = $micrositeRepository;
    }

    public function getAllMicrosites(): LengthAwarePaginator
    {
        Log::info('Fetching all microsites');
        return Cache::remember('microsites', 60, function () {
            return $this->micrositeRepository->paginate(Constants::RECORDS_PER_PAGE);
        });
    }

    public function getMicrositeById(int $id): ?Microsite
    {
        Log::info("Fetching microsite with id: {$id}");
        return Cache::remember("microsite_{$id}", 60, function () use ($id) {
            return $this->micrositeRepository->find($id);
        });
    }

    public function createMicrosite(array $data): Microsite
    {
        if (isset($data['logo'])) {
            $data = $this->saveLogo($data);
        }

        Log::info('Creating a new microsite', ['data' => $data]);
        return $this->micrositeRepository->create($data);
    }

    public function updateMicrosite(int $id, array $data): bool
    {
        $microsite = $this->getMicrositeById($id);

        if (isset($data['logo']) && !is_string($data['logo'])) {
            $data = $this->saveLogo($data);
        }

        $this->deleteFile($microsite->logo);

        Log::info("Updating microsite with id: {$id}", ['data' => $data]);
        return $this->micrositeRepository->update($id, $data);
    }

    public function deleteMicrosite(int $id): bool
    {
        $microsite = $this->getMicrositeById($id);

        $this->deleteFile($microsite->logo);
        Log::info("Deleting microsite with id: {$id}");
        return $this->micrositeRepository->delete($id);
    }

    private function saveLogo(array $data): array
    {
        $originalName = $data['logo']->getClientOriginalName();
        $data['logo']->storeAs('public/microsites', $originalName);
        $data['logo'] = "storage/microsites/{$originalName}";

        return $data;
    }

    private function deleteFile(string $path): void
    {
        $relativePath = str_replace('storage/', '', $path);

        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}
