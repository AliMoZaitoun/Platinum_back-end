<?php

namespace App\Http\Controllers\V1\Finance;

use App\DTOs\Finance\Create\CreatePaymentDTO;
use App\DTOs\Finance\Update\UpdatePaymentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Finance\CreatePaymentRequest;
use App\Http\Requests\V1\Finance\PayCustomAmountRequest;
use App\Http\Requests\V1\Finance\UpdatePaymentRequest;
use App\Http\Requests\V1\Finance\UploadPaymentProofRequest;
use App\Http\Resources\V1\Finance\ClientPaymentResource;
use App\Http\Resources\V1\Finance\ContractPaymentsGroupResource;
use App\Http\Resources\V1\Finance\PaymentResource;
use App\Services\Finance\PaymentService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private PaymentService $service
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only([
            'status',
            'client_id',
            'contract_id',
            'payment_type',
            'from_date',
            'to_date',
            'view_all'
        ]);

        $payments = $this->service->index($filters);
        return $this->successCollection($payments, PaymentResource::class);
    }

    public function store(CreatePaymentRequest $request)
    {
        $employee = Auth::user()->employee;
        $dto = CreatePaymentDTO::fromRequest($request->validated(), $employee->id);
        $payment = $this->service->store($dto, $employee->id, $request->file('attachments'));
        return $this->useResource($payment, PaymentResource::class, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $payment = $this->service->show($id);
        return $this->useResource($payment, PaymentResource::class);
    }

    public function getMine()
    {
        $client = Auth::user()->client;

        $payments = $this->service->byClient($client->id);

        $paymentsCollection = collect($payments);

        if ($paymentsCollection->isEmpty()) {
            return $this->successResponse([]);
        }

        $formattedPayments = $paymentsCollection->values();

        return $this->successCollection($formattedPayments, ContractPaymentsGroupResource::class);
    }

    public function getForClient(int $client_id)
    {
        $payments = $this->service->byClient($client_id);
        return $this->successCollection($payments, ContractPaymentsGroupResource::class);
    }

    public function byContract(int $contractId)
    {
        $payments = $this->service->byContract($contractId);
        return $this->successCollection($payments, PaymentResource::class);
    }

    public function payCustomAmount(PayCustomAmountRequest $request, int $contractId)
    {
        $employee = Auth::user()->employee;

        $this->service->payCustomAmount($contractId, $request->validated(), $request->file('attachments'), $employee->id);

        return $this->successResponse(
            data: [],
            message: __('messages.payment.custom_payment_success')
        );
    }

    public function update(int $id, UpdatePaymentRequest $request)
    {
        $employee = Auth::user()->employee;
        $dto = UpdatePaymentDTO::fromRequest($request->toArray());
        $payment = $this->service->update($id, $dto, $employee->id, $request->file('attachments'));
        return $this->useResource($payment, PaymentResource::class, __('messages.common.updated'));
    }

    public function uploadFile(int $id, UploadPaymentProofRequest $request)
    {
        $payment = $this->service->uploadFile($id, $request->file('attachments'));
        return $this->useResource($payment, PaymentResource::class, __('messages.common.updated'));
    }

    public function destroy(int $id)
    {
        $this->service->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
