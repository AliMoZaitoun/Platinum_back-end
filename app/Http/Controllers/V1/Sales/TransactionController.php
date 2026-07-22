<?php

namespace App\Http\Controllers\V1\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sales\CancelTransactionRequest;
use App\Http\Resources\V1\Sales\TransactionResource;
use App\DTOs\Sales\Create\CreateTransactionDTO;
use App\Http\Requests\V1\Sales\CreateTransactionRequest;
use App\Services\Sales\TransactionService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    use ResponseTrait;
    public function __construct(
        protected TransactionService $service
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only([
            'type',
            'status',
            'project_id',
            'warehouse_id',
            'payment_method',
            'from_date',
            'to_date',
            'search'
        ]);

        $perPage = (int) $request->get('per_page', 15);
        $transactions = $this->service->index($filters, $perPage);

        return $this->successCollection($transactions, TransactionResource::class);
    }

    public function store(CreateTransactionRequest $request)
    {
        $dto = CreateTransactionDTO::fromRequest($request, Auth::user()->employee->id);
        $transaction = $this->service->store($dto);

        return $this->useResource($transaction, TransactionResource::class, "message.common.stored", 201);
    }

    public function show(int $id)
    {
        $transaction = $this->service->show($id);

        return $this->useResource($transaction, TransactionResource::class);
    }

    public function cancel(CancelTransactionRequest $request, int $id)
    {
        $transaction = $this->service->cancel($id, $request->validated('reason'));

        return $this->useResource($transaction, TransactionResource::class);
    }

    public function summary(Request $request)
    {
        $filters = $request->only(['project_id', 'warehouse_id', 'from_date', 'to_date']);
        $summary = $this->service->getFinancialSummary($filters);

        return $this->successResponse($summary);
    }

    public function partyStatement(Request $request, string $partyType, int $partyId)
    {
        $formattedPartyType = str_replace('-', '\\', $partyType);
        $perPage = (int) $request->get('per_page', 15);

        $transactions = $this->service->getPartyStatement($formattedPartyType, $partyId, $perPage);

        return $this->successCollection($transactions, TransactionResource::class);
    }

    public function warehouseTransactions(Request $request, int $warehouseId)
    {
        $perPage = (int) $request->get('per_page', 15);
        $transactions = $this->service->getWarehouseTransactions($warehouseId, $perPage);

        return $this->successCollection($transactions, TransactionResource::class);
    }

    public function projectTransactions(Request $request, int $projectId)
    {
        $perPage = (int) $request->get('per_page', 15);
        $transactions = $this->service->getProjectTransactions($projectId, $perPage);

        return $this->successCollection($transactions, TransactionResource::class);
    }
}
