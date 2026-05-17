<?php

namespace App\DTOs\Marketing\Create;

use Carbon\Carbon;

class CreateAdDTO
{
    public function __construct(
        public string $title,
        public string $description,
        public Carbon $starts_at,
        public Carbon $ends_at,
        public int $duration_days,
        public bool $status,
        public ?int $created_by
    ) {}

    public static function fromRequest(array $data): self
    {
        $startsAt = isset($data['starts_at']) ? Carbon::parse($data['starts_at']) : now();
        $durationDays = (int) ($data['duration_days'] ?? 7);
        $endsAt = $startsAt->copy()->addDays($durationDays);

        return new self(
            title: $data['title'],
            description: $data['description'],
            starts_at: $startsAt,
            ends_at: $endsAt,
            duration_days: $durationDays,
            status: (bool) ($data['status'] ?? true),
            created_by: $data['created_by'] ?? null
        );
    }

    public function toArray()
    {
        return array_filter([
            'title'         => $this->title,
            'description'   => $this->description,
            'starts_at'     => $this->starts_at->format('Y-m-d H:i:s'),
            'ends_at'       => $this->ends_at->format('Y-m-d H:i:s'),
            'duration_days' => $this->duration_days,
            'status'        => $this->status,
            'created_by' => $this->created_by
        ], fn($value) => !is_null($value));
    }
}
