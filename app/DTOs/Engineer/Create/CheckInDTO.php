<?php

namespace App\DTOs\Engineer\Create;

class CheckInDTO
{
    public function __construct(
        public string $uuid,
        public int $project_id,
        public ?int $engineer_id,
        public string $check_in_lat,
        public string $check_in_lng,
        public string $device_id,
        public string $checked_in_at
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            uuid: $request['uuid'],
            project_id: $request['project_id'],
            engineer_id: $request['engineer_id'] ?? null,
            check_in_lat: $request['check_in_lat'],
            check_in_lng: $request['check_in_lng'],
            device_id: $request['device_id'],
            checked_in_at: $request['checked_in_at']
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'uuid'                  => $this->uuid,
            'project_id'            => $this->project_id,
            'engineer_id'           => $this->engineer_id,
            'check_in_lat'          => $this->check_in_lat,
            'check_in_lng'          => $this->check_in_lng,
            'device_id'             => $this->device_id,
            'checked_in_at'         => $this->checked_in_at
        ], fn($value) => !is_null($value));
    }
}
