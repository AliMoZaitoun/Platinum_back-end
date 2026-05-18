<?php

namespace App\DTOs\RealEstate\Create;

class CreateBuildingDTO
{
    public function __construct(
        public int $project_id,
        public ?int $location_id,
        public string $building_number,
        public float $latitude,
        public float $longitude,
        public int $radius_meters,
        public int $floors_count,
        public string $status,
        public ?string $description
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            project_id: $request['project_id'],
            location_id: $request['location_id'] ?? null,
            building_number: $request['building_number'],
            latitude: $request['latitude'] ?? null,
            longitude: $request['longitude'] ?? null,
            radius_meters: $request['radius_meters'],
            floors_count: $request['floors_count'],
            status: $request['status'],
            description: $request['description'] ?? null
        );
    }

    public function toArray()
    {
        return array_filter([
            'project_id'  => $this->project_id,
            'location_id'  => $this->location_id,
            'building_number'  => $this->building_number,
            'latitude'      => $this->latitude,
            'longitude'     => $this->longitude,
            'radius_meters' => $this->radius_meters,
            'floors_count'  => $this->floors_count,
            'status' => $this->status,
            'description' => $this->description
        ], fn($value) => !is_null($value));
    }
}
