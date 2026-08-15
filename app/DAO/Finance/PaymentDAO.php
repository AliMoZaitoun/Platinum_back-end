<?php

namespace App\DAO\Finance;

use App\DTOs\Finance\Create\CreatePaymentDTO;
use App\DTOs\Finance\Update\UpdatePaymentDTO;
use App\Exceptions\NotFoundException;
use App\Models\Finance\Payment;

class PaymentDAO
{
    public function index(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = ['client', 'attachments', 'contract'];
        $allRelations = array_merge($defaultRelations, $relations);
        return Payment::query()
            ->with($allRelations)
            ->latest()
            ->paginate($perPage);
    }

    public function store(CreatePaymentDTO $dto)
    {
        return Payment::create($dto->toArray());
    }

    public function show(int $id)
    {
        return Payment::with(['client', 'attachments', 'employee'])->where('id', $id)->first() ?? throw new NotFoundException("Payment");
    }

    public function byClient(int $client_id)
    {
        return Payment::where('client_id', $client_id)
            ->latest()
            ->with(['attachments'])
            ->get()
            ->groupBy('contract_id');
    }

    public function byContract(int $contract_id)
    {
        return Payment::where('contract_id', $contract_id)
            ->where(function ($query) {
                $query->where('payment_date', '<', now()->startOfMonth())
                    ->whereIn('status', ['pending', 'failed'])

                    ->orWhere('payment_date', '>=', now()->startOfMonth());
            })
            ->orderBy('payment_date', 'asc')
            ->with(['attachments', 'contract'])
            ->get();
    }

    public function update(int $id, UpdatePaymentDTO $dto)
    {
        $payment = $this->show($id);
        $payment->update($dto->toArray());
        return $payment->refresh();
    }

    public function destroy(int $id)
    {
        $payment = $this->show($id);
        return $payment->delete();
    }
}
