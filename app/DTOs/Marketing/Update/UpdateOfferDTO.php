<?php

namespace App\DTOs\Marketing\Update;

use Carbon\Carbon;

class UpdateOfferDTO
{
    public function __construct(
        public ?int $ad_id,
        public ?float $old_price,
        public ?float $new_price,
        public ?Carbon $start_date,
        public ?Carbon $end_date,
        public ?int $duration_days,
        public ?bool $status,
    ) {}

    public static function fromRequest(array $data): self
    {
        $start_date = isset($data['start_date']) ? Carbon::parse($data['start_date']) : now();
        $durationDays = (int) ($data['duration_days'] ?? 7);
        $end_date = $start_date->copy()->addDays($durationDays);

        return new self(
            ad_id: $data['ad_id'] ?? null,
            old_price: $data['old_price'] ?? null,
            new_price: $data['new_price'] ?? null,
            start_date: $start_date ?? null,
            end_date: $end_date ?? null,
            duration_days: $durationDays ?? null,
            status: (bool) ($data['status'] ?? true),
        );
    }

    public function toArray()
    {
        return array_filter([
            'ad_id'         => $this->ad_id,
            'old_price'     => $this->old_price,
            'new_price'     => $this->new_price,
            'start_date'    => $this->start_date->format('Y-m-d H:i:s'),
            'end_date'      => $this->end_date->format('Y-m-d H:i:s'),
            'duration_days' => $this->duration_days,
            'status'        => $this->status,
        ], fn($value) => !is_null($value));
    }
}
