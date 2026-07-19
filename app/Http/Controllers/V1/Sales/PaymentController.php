<?php

namespace App\Http\Controllers\V1\Sales;

use App\DTOs\Sales\Create\CreatePaymentDTO;
use App\DTOs\Sales\Update\UpdatePaymentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sales\CreatePaymentRequest;
use App\Http\Requests\V1\Sales\UpdatePaymentRequest;
use App\Http\Requests\V1\Sales\UploadPaymentProofRequest;
use App\Http\Resources\V1\Sales\ClientPaymentResource;
use App\Http\Resources\V1\Sales\ContractPaymentsGroupResource;
use App\Http\Resources\V1\Sales\PaymentResource;
use App\Services\Sales\PaymentService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private PaymentService $service
    ) {}

    public function index()
    {
        $payments = $this->service->index();
        return $this->successCollection($payments, PaymentResource::class);
    }

    public function store(CreatePaymentRequest $request)
    {
        $employee = Auth::user()->employee;
        $dto = CreatePaymentDTO::fromRequest($request->validated(), $employee->id);
        $payment = $this->service->store($dto, $request->file('attachments'));
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
        return $this->successCollection($payments, ContractPaymentsGroupResource::class);
    }

    public function getForClient(int $client_id)
    {
        $payments = $this->service->byClient($client_id);
        return $this->successCollection($payments, ContractPaymentsGroupResource::class);
    }

    public function update(int $id, UpdatePaymentRequest $request)
    {
        $dto = UpdatePaymentDTO::fromRequest($request->toArray());
        $payment = $this->service->update($id, $dto, $request->file('attachments'));
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
