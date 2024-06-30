<?php

namespace App\Domains\Microsite\Services;

use App\Constants\Constants;
use App\Domains\Microsite\Models\Microsite;
use App\Domains\Microsite\Repositories\MicrositeRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class MicrositeService
{
    protected $micrositeRepository;

    public function __construct(MicrositeRepository $micrositeRepository)
    {
        $this->micrositeRepository = $micrositeRepository;
    }

    public function getAllMicrosites(): LengthAwarePaginator
    {
        return $this->micrositeRepository->paginate(Constants::RECORDS_PER_PAGE);
    }

    public function getMicrositeById(int $id): ?Microsite
    {
        return $this->micrositeRepository->find($id);
    }

    public function createMicrosite(array $data): Microsite
    {
        if (isset($data['logo'])) {
            $data = $this->saveLogo($data);
        }

        return $this->micrositeRepository->create($data);
    }

    public function updateMicrosite(int $id, array $data): bool
    {
        $microsite = $this->getMicrositeById($id);

        if (isset($data['logo'])) {
            if (! is_string($data['logo'])) {
                $data = $this->saveLogo($data);
            }
        }

        $this->deleteFile($microsite->logo);

        return $this->micrositeRepository->update($id, $data);
    }

    public function deleteMicrosite(int $id): bool
    {
        $microsite = $this->getMicrositeById($id);

        $this->deleteFile($microsite->logo);

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
