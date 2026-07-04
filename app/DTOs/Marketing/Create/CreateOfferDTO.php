<?php

namespace App\DTOs\Marketing\Create;

use Carbon\Carbon;

class CreateOfferDTO
{
    public function __construct(
        public ?int $ad_id,
        public ?float $discount_percentage,
        public Carbon $start_date,
        public Carbon $end_date,
        public int $duration_days,
        public bool $status,
        public int $created_by
    ) {}

    public static function fromRequest(array $data, int $created_by): self
    {
        $start_date = isset($data['start_date']) ? Carbon::parse($data['start_date']) : now();
        $durationDays = (int) ($data['duration_days'] ?? 7);
        $end_date = $start_date->copy()->addDays($durationDays);

        return new self(
            ad_id: $data['ad_id'],
            discount_percentage: $data['discount_percentage'],
            start_date: $start_date,
            end_date: $end_date,
            duration_days: $durationDays,
            status: (bool) ($data['status'] ?? true),
            created_by: $created_by
        );
    }

    public function toArray()
    {
        return array_filter([
            'ad_id'         => $this->ad_id,
            'discount_percentage'     => $this->discount_percentage,
            'start_date'    => $this->start_date->format('Y-m-d H:i:s'),
            'end_date'      => $this->end_date->format('Y-m-d H:i:s'),
            'duration_days' => $this->duration_days,
            'status'        => $this->status,
            'created_by'    => $this->created_by
        ], fn($value) => !is_null($value));
    }
}
