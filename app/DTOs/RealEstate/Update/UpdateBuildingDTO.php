<?php

namespace App\DTOs\RealEstate\Update;

class UpdateBuildingDTO
{
    public function __construct(
        public ?int $location_id,
        public ?string $building_number,
        public ?int $floors_count,
        public ?string $description,
        public ?string $status,
        public ?string $start_date,
        public ?string $end_date,
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            location_id: $request['location_id'] ?? null,
            building_number: $request['building_number'] ?? null,
            floors_count: $request['floors_count'] ?? null,
            description: $request['description'] ?? null,
            status: $request['status'] ?? null,
            start_date: $request['start_date'] ?? null,
            end_date: $request['end_date'] ?? null,
        );
    }

    public function toArray()
    {
        return array_filter([
            'location_id'  => $this->location_id,
            'building_number'  => $this->building_number,
            'floors_count'  => $this->floors_count,
            'description' => $this->description,
            'status' => $this->status,
            'start_date'   => $this->start_date,
            'end_date'     => $this->end_date,
        ], fn($value) => !is_null($value));
    }
}
