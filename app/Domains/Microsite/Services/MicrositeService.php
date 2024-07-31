<?php

namespace App\Domains\Microsite\Services;

use App\Constants\Constants;
use App\Domains\Microsite\Models\Microsite;
use App\Domains\Microsite\Repositories\MicrositeRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
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
        return $this->micrositeRepository->paginate(Constants::RECORDS_PER_PAGE_MICROSITE);
    }

    public function getMicrositeById(int $id): ?Microsite
    {
        Log::info("Fetching microsite with id: {$id}");
        return $this->micrositeRepository->find($id);
    }

    public function createMicrosite(array $data): Microsite
    {
        if (isset($data['logo']) && $data['logo']->isValid()) {
            $data['logo'] = $this->saveLogo($data['logo']);
        }

        Log::info('Creating a new microsite', ['data' => $data]);
        return $this->micrositeRepository->create($data);
    }

    public function updateMicrosite(int $id, array $data): bool
    {
        Log::info("Updating microsite with id: {$id}", ['data' => $data]);
        $microsite = $this->getMicrositeById($id);

        if (isset($data['logo']) && $data['logo']->isValid()) {
            $oldLogoPath = $microsite->logo;
            $data['logo'] = $this->saveLogo($data['logo']);
            $this->deleteFile($oldLogoPath);
        }

        return $this->micrositeRepository->update($id, $data);
    }

    public function deleteMicrosite(int $id): bool
    {
        $microsite = $this->getMicrositeById($id);
        if ($microsite && $microsite->logo) {
            $this->deleteFile($microsite->logo);
        }

        Log::info("Deleting microsite with id: {$id}");
        return $this->micrositeRepository->delete($id);
    }

    private function saveLogo($file): string
    {
        $originalName = $file->getClientOriginalName();
        $path = $file->storeAs('public/microsites', $originalName);
        return "storage/microsites/{$originalName}";
    }

    private function deleteFile(string $filePath): void
    {
        $relativePath = str_replace('storage/', 'public/', $filePath);
        if (Storage::exists($relativePath)) {
            Storage::delete($relativePath);
        }
    }
}
