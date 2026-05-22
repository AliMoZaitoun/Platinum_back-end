<?php

namespace App\DTOs\Engineer\Create;

class CheckInDTO
{
    public function __construct(
        public string $uuid,
        public int $project_id,
        public ?int $building_id,
        public ?int $engineer_id,
        public string $check_in_lat,
        public string $check_in_lng,
        public string $device_id,
        public string $checked_in_at,
        public bool $is_mock,
        public float $gps_accuracy
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            uuid: $request['uuid'],
            project_id: $request['project_id'],
            building_id: $request['building_id'] ?? null,
            engineer_id: $request['engineer_id'] ?? null,
            check_in_lat: $request['check_in_lat'],
            check_in_lng: $request['check_in_lng'],
            device_id: $request['device_id'],
            checked_in_at: $request['checked_in_at'],
            is_mock: $request['is_mock'],
            gps_accuracy: $request['gps_accuracy'],
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'uuid'                  => $this->uuid,
            'project_id'            => $this->project_id,
            'building_id'           => $this->building_id,
            'engineer_id'           => $this->engineer_id,
            'check_in_lat'          => $this->check_in_lat,
            'check_in_lng'          => $this->check_in_lng,
            'device_id'             => $this->device_id,
            'checked_in_at'         => $this->checked_in_at,
            'is_mock'               => $this->is_mock,
            'gps_accuracy'          => $this->gps_accuracy,
        ], fn($value) => !is_null($value));
    }
}
