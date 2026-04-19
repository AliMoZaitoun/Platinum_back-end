<?php

namespace App\DTOs\RealEstate\Update;

class UpdateBuildingDTO
{
    public function __construct(
        public ?string $building_number,
        public ?int $floors_count,
        public ?string $status
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            building_number: $request['building_number'] ?? null,
            floors_count: $request['floors_count'] ?? null,
            status: $request['status'] ?? null
        );
    }

    public function toArray()
    {
        return array_filter([
            'building_number'  => $this->building_number,
            'floors_count'  => $this->floors_count,
            'status' => $this->status
        ], fn($value) => !is_null($value));
    }
}
