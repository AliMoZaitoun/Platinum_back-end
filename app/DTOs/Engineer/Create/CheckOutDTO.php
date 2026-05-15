<?php

namespace App\DTOs\Engineer\Create;

class CheckOutDTO
{
    public function __construct(
        public string $uuid,
        public int $project_id,
        public ?int $engineer_id,
        public string $check_out_lat,
        public string $check_out_lng,
        public ?string $device_id,
        public string $checked_out_at
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            uuid: $request['uuid'],
            project_id: $request['project_id'],
            engineer_id: $request['engineer_id'] ?? null,
            check_out_lat: $request['check_out_lat'],
            check_out_lng: $request['check_out_lng'],
            device_id: $request['device_id'] ?? null,
            checked_out_at: $request['checked_out_at']
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'uuid'                  => $this->uuid,
            'project_id'            => $this->project_id,
            'engineer_id'           => $this->engineer_id,
            'check_out_lat'         => $this->check_out_lat,
            'check_out_lng'         => $this->check_out_lng,
            'device_id'             => $this->device_id,
            'checked_out_at'        => $this->checked_out_at
        ], fn($value) => !is_null($value));
    }
}
