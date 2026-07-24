<?php

namespace App\DTOs\Marketing\Update;

use Carbon\Carbon;

class UpdateOfferDTO
{
    public function __construct(
        public ?bool $status,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            status: (bool) ($data['status'] ?? true),
        );
    }

    public function toArray()
    {
        return array_filter([
            'status'        => $this->status,
        ], fn($value) => !is_null($value));
    }
}
