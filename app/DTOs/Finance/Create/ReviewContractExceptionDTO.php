<?php

namespace App\DTOs\Finance\Create;

use App\Http\Requests\V1\Finance\ReviewContractExceptionRequest;

class ReviewContractExceptionDTO
{
    public function __construct(
        public readonly int $exceptionId,
        public readonly int $actionByEmployeeId,
        public readonly string $status, // 'approved' or 'rejected'
        public readonly ?string $rejectionReason = null,
    ) {}

    public static function fromRequest(ReviewContractExceptionRequest $request, int $exceptionId, int $employeeId): self
    {
        return new self(
            exceptionId: $exceptionId,
            actionByEmployeeId: $employeeId,
            status: $request->validated('status'),
            rejectionReason: $request->validated('rejection_reason'),
        );
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function toArray(): array
    {
        return array_filter([
            'action_by'        => $this->actionByEmployeeId,
            'status'           => $this->status,
            'rejection_reason' => $this->rejectionReason,
        ], fn($value) => $value !== null);
    }
}
