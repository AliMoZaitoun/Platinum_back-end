<?php

namespace App\DTOs\RealEstate\Update;

class UpdateBuildingDTO
{
    public function __construct(
        public ?int $location_id,
        public ?string $building_number,
        public ?int $floors_count,
        public ?string $status
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            location_id: $request['location_id'] ?? null,
            building_number: $request['building_number'] ?? null,
            floors_count: $request['floors_count'] ?? null,
            status: $request['status'] ?? null
        );
    }

    public function toArray()
    {
        return array_filter([
            'location_id'  => $this->location_id,
            'building_number'  => $this->building_number,
            'floors_count'  => $this->floors_count,
            'status' => $this->status
        ], fn($value) => !is_null($value));
    }
}
