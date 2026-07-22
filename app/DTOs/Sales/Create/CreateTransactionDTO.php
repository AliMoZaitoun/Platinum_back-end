<?php

namespace App\DTOs\Sales\Create;

use App\Enums\TransactionCategory;

class CreateTransactionDTO
{
    public function __construct(
        public ?string $voucher_number = null,
        public ?string $type = null,                      // 'receipt' or 'payment'
        public ?float $amount = null,
        public string $currency = 'USD',
        public float $exchange_rate = 1.0,
        public ?TransactionCategory $category = null,
        public ?string $payment_method = null,            // 'cash', 'bank_transfer', 'check', 'card'
        public int $created_by = 0,
        public ?string $transactionable_type = null,
        public ?int $transactionable_id = null,
        public ?int $project_id = null,
        public ?int $warehouse_id = null,
        public ?string $party_type = null,
        public ?int $party_id = null,
        public ?string $status = 'posted',                // 'draft', 'posted', 'cancelled'
        public ?string $description = null
    ) {}

    public static function fromRequest($request, int $userId): self
    {
        $category = $request->validated('category');

        if (is_string($category)) {
            $category = TransactionCategory::tryFrom($category);
        }

        return new self(
            voucher_number: $request->validated('voucher_number'),
            type: $request->validated('type'),
            amount: $request->validated('amount') !== null ? (float) $request->validated('amount') : null,
            currency: $request->validated('currency', 'USD'),
            exchange_rate: (float) $request->validated('exchange_rate', 1.0),
            category: $category,
            payment_method: $request->validated('payment_method'),
            created_by: $userId,
            transactionable_type: $request->validated('transactionable_type'),
            transactionable_id: $request->validated('transactionable_id'),
            project_id: $request->validated('project_id'),
            warehouse_id: $request->validated('warehouse_id'),
            party_type: $request->validated('party_type'),
            party_id: $request->validated('party_id'),
            status: $request->validated('status', 'posted'),
            description: $request->validated('description')
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'voucher_number'       => $this->voucher_number,
            'type'                 => $this->type,
            'amount'               => $this->amount,
            'currency'             => $this->currency,
            'exchange_rate'        => $this->exchange_rate,
            'category'             => $this->category?->value,
            'payment_method'       => $this->payment_method,
            'created_by'           => $this->created_by,
            'transactionable_type' => $this->transactionable_type,
            'transactionable_id'   => $this->transactionable_id,
            'project_id'           => $this->project_id,
            'warehouse_id'         => $this->warehouse_id,
            'party_type'           => $this->party_type,
            'party_id'             => $this->party_id,
            'status'               => $this->status,
            'description'          => $this->description,
        ], fn($value) => $value !== null);
    }
}
