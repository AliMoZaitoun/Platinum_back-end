<?php

namespace App\DTOs\RealEstate\Update;

class UpdateProjectDTO
{
    public function __construct(
        public ?string $name,
        public ?string $description,
        public ?float $latitude,
        public ?float $longitude,
        public ?int $radius_meters,
        public ?string $status
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            name: $request['name'] ?? null,
            description: $request['description'] ?? null,
            latitude: $request['latitude'] ?? null,
            longitude: $request['longitude'] ?? null,
            radius_meters: $request['radius_meters'] ?? null,
            status: $request['status'] ?? null
        );
    }

    public function toArray()
    {
        return array_filter([
            'name'  => $this->name,
            'description'  => $this->description,
            'latitude'  => $this->latitude,
            'longitude'  => $this->longitude,
            'radius_meters' => $this->radius_meters,
            'status' => $this->status
        ], fn($value) => !is_null($value));
    }
}
