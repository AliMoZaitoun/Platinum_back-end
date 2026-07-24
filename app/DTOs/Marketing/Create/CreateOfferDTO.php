<?php

namespace App\DTOs\Marketing\Create;

use Carbon\Carbon;

class CreateOfferDTO
{
    public function __construct(
        public ?int $advertisement_id,
        public float $discount_percentage,
        public float $old_price,
        public float $new_price,
        public Carbon $start_date,
        public ?Carbon $end_date,
        public string $offerable_type,
        public int $offerable_id,
        public bool $status,
        public int $created_by
    ) {}

    public static function fromRequest(array $data, int $created_by, float $oldPrice, float $newPrice): self
    {
        $start_date = isset($data['start_date']) ? Carbon::parse($data['start_date']) : now();

        $end_date = null;
        if (!empty($data['duration_days'])) {
            $end_date = $start_date->copy()->addDays((int) $data['duration_days']);
        } elseif (!empty($data['end_date'])) {
            $end_date = Carbon::parse($data['end_date']);
        }

        return new self(
            advertisement_id: isset($data['advertisement_id']) ? (int) $data['advertisement_id'] : null,
            discount_percentage: (float) $data['discount_percentage'],
            old_price: $oldPrice,
            new_price: $newPrice,
            start_date: $start_date,
            end_date: $end_date,
            offerable_type: $data['offerable_type'],
            offerable_id: (int) $data['offerable_id'],
            status: (bool) ($data['status'] ?? true),
            created_by: $created_by
        );
    }

    public function toArray(): array
    {
        return [
            'advertisement_id'    => $this->advertisement_id,
            'discount_percentage' => $this->discount_percentage,
            'old_price'           => $this->old_price,
            'new_price'           => $this->new_price,
            'start_date'          => $this->start_date->format('Y-m-d H:i:s'),
            'end_date'            => $this->end_date?->format('Y-m-d H:i:s'),
            'offerable_type'      => $this->offerable_type,
            'offerable_id'        => $this->offerable_id,
            'status'              => $this->status,
            'created_by'          => $this->created_by,
        ];
    }
}
