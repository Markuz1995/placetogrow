<?php

namespace App\Infrastructure\Persistence;

use App\Domains\PaymentRecord\Models\PaymentRecord;
use App\Domains\PaymentRecord\Repositories\PaymentRecordRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class PaymentRecordRepositoryEloquent implements PaymentRecordRepository
{
    public function getAllByMicrositeId(int $micrositeId, int $perPage): LengthAwarePaginator
    {
        return PaymentRecord::where('microsite_id', $micrositeId)->paginate($perPage);
    }

    public function create(array $data): PaymentRecord
    {
        return PaymentRecord::create($data);
    }

    public function find(int $id): ?PaymentRecord
    {
        return PaymentRecord::find($id);
    }

    public function update(int $id, array $data): bool
    {
        $paymentRecord = $this->find($id);
        return $paymentRecord->update($data);
    }

    public function delete(int $id): bool
    {
        $paymentRecord = $this->find($id);
        return $paymentRecord->delete();
    }
}
