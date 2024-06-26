<?php

namespace App\Domains\Microsite\Services;

use App\Domains\Microsite\Repositories\MicrositeRepository;
use App\Domains\Microsite\Models\Microsite;
use Illuminate\Support\Collection;

class MicrositeService
{
    protected $micrositeRepository;

    public function __construct(MicrositeRepository $micrositeRepository)
    {
        $this->micrositeRepository = $micrositeRepository;
    }

    public function getAllMicrosites(): Collection
    {
        return $this->micrositeRepository->all();
    }

    public function getMicrositeById(int $id): ?Microsite
    {
        return $this->micrositeRepository->find($id);
    }

    public function createMicrosite(array $data): Microsite
    {
        return $this->micrositeRepository->create($data);
    }

    public function updateMicrosite(int $id, array $data): bool
    {
        return $this->micrositeRepository->update($id, $data);
    }

    public function deleteMicrosite(int $id): bool
    {
        return $this->micrositeRepository->delete($id);
    }
}
