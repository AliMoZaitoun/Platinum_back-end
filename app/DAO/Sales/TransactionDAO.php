<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreateTransactionDTO;
use App\Models\Sales\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TransactionDAO
{
    public function index(array $filters = [], array $relations = [], int $perPage = 15): LengthAwarePaginator
    {
        $defaultRelations = ['creator', 'party'];
        $allRelations = array_merge($defaultRelations, $relations);

        $query = Transaction::query()->with($allRelations);

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['project_id'])) {
            $query->where('project_id', $filters['project_id']);
        }

        if (!empty($filters['warehouse_id'])) {
            $query->where('warehouse_id', $filters['warehouse_id']);
        }

        if (!empty($filters['payment_method'])) {
            $query->where('payment_method', $filters['payment_method']);
        }

        if (!empty($filters['from_date'])) {
            $query->whereDate('created_at', '>=', $filters['from_date']);
        }
        if (!empty($filters['to_date'])) {
            $query->whereDate('created_at', '<=', $filters['to_date']);
        }

        if (!empty($filters['search'])) {
            $query->where('voucher_number', 'LIKE', "%{$filters['search']}%");
        }

        return $query->latest()->paginate($perPage);
    }

    public function store(array $data): Transaction
    {
        return Transaction::create($data);
    }

    public function lastNumber($type, $year)
    {
        $lastTransaction = Transaction::where('type', $type)
            ->whereYear('created_at', $year)
            ->latest('id')
            ->first();
    }


    public function show(int $id, array $relations = []): Transaction
    {
        $defaultRelations = ['creator', 'party', 'transactionable', 'project', 'warehouse'];
        $allRelations = array_merge($defaultRelations, $relations);

        return Transaction::with($allRelations)->findOrFail($id);
    }

    public function cancel(int $id, string $reason): Transaction
    {
        $transaction = $this->show($id);

        $cancellationNote = "\n[CANCELLED AT " . now()->format('Y-m-d H:i') . " | REASON: {$reason}]";

        $transaction->update([
            'status'      => 'cancelled',
            'description' => $transaction->description . $cancellationNote,
        ]);

        return $transaction->refresh();
    }

    public function byParty(string $partyType, int $partyId, int $perPage = 15): LengthAwarePaginator
    {
        return Transaction::query()
            ->where('party_type', $partyType)
            ->where('party_id', $partyId)
            ->with(['creator', 'transactionable'])
            ->latest()
            ->paginate($perPage);
    }

    public function byWarehouse(int $warehouseId, int $perPage = 15): LengthAwarePaginator
    {
        return Transaction::query()
            ->where('warehouse_id', $warehouseId)
            ->with(['creator', 'party'])
            ->latest()
            ->paginate($perPage);
    }

    public function byProject(int $projectId, int $perPage = 15): LengthAwarePaginator
    {
        return Transaction::query()
            ->where('project_id', $projectId)
            ->with(['creator', 'party'])
            ->latest()
            ->paginate($perPage);
    }

    public function getFinancialSummary(array $filters = []): array
    {
        $query = Transaction::query()->where('status', 'posted');

        if (!empty($filters['project_id'])) {
            $query->where('project_id', $filters['project_id']);
        }

        if (!empty($filters['warehouse_id'])) {
            $query->where('warehouse_id', $filters['warehouse_id']);
        }

        if (!empty($filters['from_date'])) {
            $query->whereDate('created_at', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->whereDate('created_at', '<=', $filters['to_date']);
        }

        $totalReceipts = (clone $query)->where('type', 'receipt')->sum('amount');
        $totalPayments = (clone $query)->where('type', 'payment')->sum('amount');

        return [
            'total_receipts' => (float) $totalReceipts,
            'total_payments' => (float) $totalPayments,
            'net_balance'    => (float) ($totalReceipts - $totalPayments),
        ];
    }
}
