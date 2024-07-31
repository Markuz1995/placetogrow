<?php

namespace App\Domains\Role\Services;

use App\Constants\Constants;
use App\Domains\Role\Repositories\RoleRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RoleService
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getAllRoles(): LengthAwarePaginator
    {
        Log::info('Fetching all roles');
        return $this->roleRepository->paginate(Constants::RECORDS_PER_PAGE);
    }

    public function getRoleById(int $id): ?Role
    {
        Log::info("Fetching role with id: {$id}");
        return $this->roleRepository->find($id);
    }

    public function createRole(array $data): Role
    {
        Log::info('Creating a new role', ['data' => $data]);
        return $this->roleRepository->create($data);
    }

    public function updateRole(int $id, array $data): bool
    {
        Log::info("Updating role with id: {$id}", ['data' => $data]);
        return $this->roleRepository->update($id, $data);
    }

    public function deleteRole(int $id): bool
    {
        Log::info("Deleting role with id: {$id}");
        return $this->roleRepository->delete($id);
    }
}
