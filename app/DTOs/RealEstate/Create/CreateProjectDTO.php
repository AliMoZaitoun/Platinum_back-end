<?php

namespace App\DTOs\RealEstate\Create;

class CreateProjectDTO
{
    public function __construct(
        public string $name,
        public ?string $description,
        public float $latitude,
        public float $longitude,
        public int $radius_meters,
        public string $status
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            name: $request['name'],
            description: $request['description'] ?? null,
            latitude: $request['latitude'],
            longitude: $request['longitude'],
            radius_meters: $request['radius_meters'],
            status: $request['status']
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
