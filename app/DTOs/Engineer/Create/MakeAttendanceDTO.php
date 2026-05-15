<?php

namespace App\DTOs\Engineer\Create;

class MakeAttendanceDTO
{
    public function __construct(
        public string $uuid,
        public int $project_id,
        public int $engineer_id,
        public string $check_in,
        public ?string $check_out,
        public string $check_in_lat,
        public string $check_in_lng,
        public ?string $check_out_lat,
        public ?string $check_out_lng,
        public string $device_id,
        public ?string $recorded_at
    ) {}

    public static function fromRequest(array $request): self
    {
        return new self(
            uuid: $request['uuid'],
            project_id: $request['project_id'],
            engineer_id: $request['engineer_id'],
            check_in: $request['check_in'],
            check_out: $request['check_out'] ?? null,
            check_in_lat: $request['check_in_lat'],
            check_in_lng: $request['check_in_lng'],
            check_out_lat: $request['check_out_lat'] ?? null,
            check_out_lng: $request['check_out_lng'] ?? null,
            device_id: $request['device_id'],
            recorded_at: $request['recorded_at'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'uuid'                  => $this->uuid,
            'project_id'            => $this->project_id,
            'engineer_id'           => $this->engineer_id,
            'check_in'              => $this->check_in,
            'check_out'             => $this->check_out,
            'check_in_lat'          => $this->check_in_lat,
            'check_in_lng'          => $this->check_in_lng,
            'check_out_lat'         => $this->check_out_lat,
            'check_out_lng'         => $this->check_out_lng,
            'device_id'             => $this->device_id,
            'recorded_at'           => $this->recorded_at
        ], fn($value) => !is_null($value));
    }
}
