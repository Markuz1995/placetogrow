<?php

namespace App\Http\Controllers;

use App\Domains\Microsite\Services\MicrositeService;
use App\Domains\PaymentRecord\Services\PaymentRecordService;
use App\Http\Requests\PaymentRecordRequest;
use Illuminate\Support\Facades\Auth;
use App\Domains\User\Models\User;

class PaymentRecordController extends Controller
{
    protected $paymentRecordService;
    protected $micrositeService;

    public function __construct(PaymentRecordService $paymentRecordService, MicrositeService $micrositeService)
    {
        $this->paymentRecordService = $paymentRecordService;
        $this->micrositeService = $micrositeService;
    }

    public function index(int $micrositeId)
    {
        $paymentRecords = $this->paymentRecordService->getAllPaymentRecordsByMicrositeId($micrositeId);

        $user = Auth::user();
        $user = User::with('roles')->find($user->id);

        return inertia('PaymentRecord/Index', [
            'micrositeId' => $micrositeId,
            'paymentRecords' => $paymentRecords,
            'auth' => [
                'user' => $user
            ]
        ]);
    }

    public function create(int $micrositeId)
    {
        return inertia('PaymentRecord/Create', ['micrositeId' => $micrositeId]);
    }

    public function store(PaymentRecordRequest $request, int $micrositeId)
    {
        $microsite = $this->micrositeService->getMicrositeById($micrositeId);
        $validated = $request->validated();
        $validated['microsite_id'] = $micrositeId;
        $validated['type'] = $microsite->type;

        $this->paymentRecordService->createPaymentRecord($validated);

        return redirect()->route('microsite.payment_records.index', $micrositeId)->with('success', 'Payment record was created');
    }

    public function show(int $micrositeId, int $id)
    {
        $paymentRecord = $this->paymentRecordService->getPaymentRecordById($id);

        return inertia('PaymentRecord/Show', [
            'micrositeId' => $micrositeId,
            'paymentRecord' => $paymentRecord,
        ]);
    }

    public function edit(int $micrositeId, int $id)
    {
        $paymentRecord = $this->paymentRecordService->getPaymentRecordById($id);

        return inertia('PaymentRecord/Edit', [
            'micrositeId' => $micrositeId,
            'paymentRecord' => $paymentRecord,
        ]);
    }

    public function update(PaymentRecordRequest $request, int $micrositeId, int $id)
    {
        $validated = $request->validated();
        $this->paymentRecordService->updatePaymentRecord($id, $validated);

        return redirect()->route('microsite.payment_records.index', $micrositeId)->with('success', 'Payment record was updated');
    }

    public function destroy(int $micrositeId, int $id)
    {
        $this->paymentRecordService->deletePaymentRecord($id);

        return redirect()->route('microsite.payment_records.index', $micrositeId)->with('success', 'Payment record was deleted');
    }
}
