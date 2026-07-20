<?php

namespace App\Http\Controllers\V1\Sales;

use App\DTOs\Sales\Create\CreateContractDTO;
use App\DTOs\Sales\Update\UpdateContractDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sales\CreateContractRequest;
use App\Http\Requests\V1\Sales\UpdateContractRequest;
use App\Http\Resources\V1\Sales\ClientContractResource;
use App\Http\Resources\V1\Sales\ContractResource;
use App\Services\Sales\ContractService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private ContractService $service
    ) {}

    public function index()
    {
        $contracts = $this->service->index();
        return $this->successCollection($contracts, ContractResource::class);
    }

    public function store(CreateContractRequest $request)
    {
        $employee = Auth::user()->employee;
        $dto = CreateContractDTO::fromRequest($request->validated(), $employee->id, null);
        $contract = $this->service->store($dto, $request->file('attachments'));
        return $this->useResource($contract, ContractResource::class, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $contract = $this->service->show($id);
        return $this->useResource($contract, ContractResource::class);
    }

    public function forClient()
    {
        $client = Auth::user()->client;
        $contracts = $this->service->byClient($client->id);
        return $this->successCollection($contracts, ClientContractResource::class);
    }

    public function byClient(int $client_id)
    {
        $contracts = $this->service->byClient($client_id);
        return $this->successCollection($contracts, ContractResource::class);
    }

    public function changeStatus(int $id, UpdateContractRequest $request)
    {
        $dto = UpdateContractDTO::fromRequest($request->toArray());
        $contract = $this->service->changeStatus($id, $dto);
        return $this->useResource($contract, ContractResource::class, __('messages.common.updated'));
    }

    public function destroy(int $id)
    {
        $this->service->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
