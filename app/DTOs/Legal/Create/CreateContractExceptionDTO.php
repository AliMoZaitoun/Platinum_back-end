<?php

namespace App\DTOs\Legal\Create;

use App\Http\Requests\V1\Legal\CreateContractRequest;

class CreateContractExceptionDTO
{
    public function __construct(
        public readonly float $originalTotalPrice,
        public readonly float $requestedTotalPrice,
        public readonly float $originalDownPayment,
        public readonly float $requestedDownPayment,
        public readonly int $originalInstallmentsCount,
        public readonly int $requestedInstallmentsCount,
        public readonly string $reason,
    ) {}

    public static function fromRequest(CreateContractRequest $request): self
    {
        return new self(
            originalTotalPrice: (float) $request->validated('original_total_price'),
            requestedTotalPrice: (float) $request->validated('total_price'),
            originalDownPayment: (float) $request->validated('original_down_payment'),
            requestedDownPayment: (float) $request->validated('down_payment_amount'),
            originalInstallmentsCount: (int) $request->validated('original_installments_count'),
            requestedInstallmentsCount: (int) $request->validated('installments_count'),
            reason: $request->validated('exception_reason'),
        );
    }

    public function toArray(int $contractId, int $requestedByUserId): array
    {
        return [
            'contract_id'                  => $contractId,
            'requested_by'                 => $requestedByUserId,
            'original_total_price'         => $this->originalTotalPrice,
            'requested_total_price'        => $this->requestedTotalPrice,
            'original_down_payment'        => $this->originalDownPayment,
            'requested_down_payment'       => $this->requestedDownPayment,
            'original_installments_count'  => $this->originalInstallmentsCount,
            'requested_installments_count' => $this->requestedInstallmentsCount,
            'reason'                       => $this->reason,
            'status'                       => 'pending',
        ];
    }
}
