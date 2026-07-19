<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreatePaymentDTO;
use App\DTOs\Sales\Update\UpdatePaymentDTO;
use App\Exceptions\NotFoundException;
use App\Models\Sales\Payment;

class PaymentDAO
{
    public function index(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = ['client', 'attachments'];
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
