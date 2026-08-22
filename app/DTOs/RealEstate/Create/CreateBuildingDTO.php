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
        public ?string $description,
        public ?string $start_date,
        public ?string $end_date,
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
            description: $request['description'] ?? null,
            start_date: $request['start_date'] ?? null,
            end_date: $request['end_date'] ?? null,
        );
    }

    public function toArray()
    {
        return array_filter([
            'project_id'        => $this->project_id,
            'location_id'       => $this->location_id,
            'building_number'   => $this->building_number,
            'latitude'          => $this->latitude,
            'longitude'         => $this->longitude,
            'radius_meters'     => $this->radius_meters,
            'floors_count'      => $this->floors_count,
            'status'            => $this->status,
            'description'       => $this->description,
            'start_date'        => $this->start_date,
            'end_date'          => $this->end_date,
        ], fn($value) => !is_null($value));
    }
}
