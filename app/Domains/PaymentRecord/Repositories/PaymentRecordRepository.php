<?php

namespace App\Domains\PaymentRecord\Repositories;


use App\Domains\PaymentRecord\Models\PaymentRecord;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PaymentRecordRepository
{
    public function getAllByMicrositeId(int $micrositeId, int $perPage): LengthAwarePaginator;
    public function create(array $data): PaymentRecord;
    public function find(int $id): ?PaymentRecord;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
