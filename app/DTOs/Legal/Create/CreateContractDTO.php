<?php

namespace App\DTOs\Legal\Create;

use App\Http\Requests\V1\Legal\CreateContractRequest;

class CreateContractDTO
{
    public function __construct(
        public readonly int $employeeId,
        public readonly int $orderId,
        public readonly float $totalPrice,
        public readonly float $downPaymentAmount,
        public readonly int $installmentsCount,
        public readonly ?CreateContractExceptionDTO $exception = null,
    ) {}

    public static function fromRequest(CreateContractRequest $request): self
    {
        $hasException = $request->boolean('has_exception');

        return new self(
            employeeId: $request->user()->employee->id,
            orderId: $request->validated('order_id'),
            totalPrice: (float) $request->validated('total_price'),
            downPaymentAmount: (float) $request->validated('down_payment_amount'),
            installmentsCount: (int) $request->validated('installments_count'),
            exception: $hasException ? CreateContractExceptionDTO::fromRequest($request) : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'employee_id'         => $this->employeeId,
            'order_id'            => $this->orderId,
            'total_price'         => $this->totalPrice,
            'down_payment_amount' => $this->downPaymentAmount,
            'installments_count'  => $this->installmentsCount,
        ], fn($value) => $value !== null);
    }
}
