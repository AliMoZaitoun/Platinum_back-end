<?php

namespace App\DTOs\Engineer\Create;

class CheckOutDTO
{
    public function __construct(
        public ?int $id,
        public ?int $project_id,
        public ?int $engineer_id,
        public string $check_out_lat,
        public string $check_out_lng,
        public string $device_id,
        public string $checked_out_at,
        public ?int $total_hours,
        public bool $is_mock,
        public float $gps_accuracy,
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            id: $request['id'] ?? null,
            project_id: $request['project_id'] ?? null,
            engineer_id: $request['engineer_id'] ?? null,
            check_out_lat: $request['check_out_lat'],
            check_out_lng: $request['check_out_lng'],
            device_id: $request['device_id'],
            checked_out_at: $request['checked_out_at'],
            total_hours: $request['total_hours'] ?? null,
            is_mock: $request['is_mock'],
            gps_accuracy: $request['gps_accuracy'],
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'check_out_lat'         => $this->check_out_lat,
            'check_out_lng'         => $this->check_out_lng,
            'checked_out_at'        => $this->checked_out_at,
            'total_hours'           => $this->total_hours,
        ], fn($value) => !is_null($value));
    }
}
