<?php

namespace App\DTOs\RealEstate\Update;

class UpdateProjectDTO
{
    public function __construct(
        public ?string $name,
        public ?string $description,
        public ?int $location_id,
        public ?float $latitude,
        public ?float $longitude,
        public ?int $radius_meters,
        public ?string $status,
        public ?string $start_date,
        public ?string $end_date
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            name: $request['name'] ?? null,
            description: $request['description'] ?? null,
            location_id: $request['location_id'] ?? null,
            latitude: $request['latitude'] ?? null,
            longitude: $request['longitude'] ?? null,
            radius_meters: $request['radius_meters'] ?? null,
            status: $request['status'] ?? null,
            start_date: $request['start_date'] ?? null,
            end_date: $request['end_date'] ?? null
        );
    }

    public function toArray()
    {
        return array_filter([
            'name'          => $this->name,
            'description'   => $this->description,
            'location_id'   => $this->location_id,
            'latitude'      => $this->latitude,
            'longitude'     => $this->longitude,
            'radius_meters' => $this->radius_meters,
            'status'        => $this->status,
            'start_date'    => $this->start_date,
            'end_date'      => $this->end_date
        ], fn($value) => !is_null($value));
    }
}
