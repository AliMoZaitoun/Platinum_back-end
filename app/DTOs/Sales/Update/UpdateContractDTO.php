<?php

namespace App\DTOs\Sales\Update;

class UpdateContractDTO
{
    public function __construct(
        public string $status
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            status: $request['status'] ?? 'draft'
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'status'    => $this->status
        ], fn($value) => !is_null($value));
    }
}
