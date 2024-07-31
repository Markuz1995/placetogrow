<?php

namespace App\Domains\PaymentRecord\Services;


use App\Constants\Constants;
use App\Domains\PaymentRecord\Models\PaymentRecord;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class PaymentRecordService
{
    protected $paymentRecordRepository;

    public function __construct(\App\Domains\PaymentRecord\Repositories\PaymentRecordRepository $paymentRecordRepository)
    {
        $this->paymentRecordRepository = $paymentRecordRepository;
    }

    public function getAllPaymentRecordsByMicrositeId(int $micrositeId, int $perPage = Constants::RECORDS_PER_PAGE_MICROSITE): LengthAwarePaginator
    {
        Log::info("Fetching all payment records for microsite with id: {$micrositeId}");
        return $this->paymentRecordRepository->getAllByMicrositeId($micrositeId, $perPage);
    }

    public function getPaymentRecordById(int $id): ?PaymentRecord
    {
        Log::info("Fetching payment record with id: {$id}");
        return $this->paymentRecordRepository->find($id);
    }

    public function createPaymentRecord(array $data): PaymentRecord
    {
        Log::info('Creating a new payment record', ['data' => $data]);
        return $this->paymentRecordRepository->create($data);
    }

    public function updatePaymentRecord(int $id, array $data): bool
    {
        Log::info("Updating payment record with id: {$id}", ['data' => $data]);
        return $this->paymentRecordRepository->update($id, $data);
    }

    public function deletePaymentRecord(int $id): bool
    {
        Log::info("Deleting payment record with id: {$id}");
        return $this->paymentRecordRepository->delete($id);
    }
}
