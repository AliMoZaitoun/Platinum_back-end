<?php

namespace App\DTOs\RealEstate\Other;

class SearchUnitDTO
{
    public function __construct(
        public ?int $location_id,
        public ?int $rooms_count,
        public ?int $floor,
        public ?float $area_min,
        public ?float $area_max,
        public ?string $type,
        public ?float $price_min,
        public ?float $price_max,
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            location_id: $request['location_id'] ?? null,
            rooms_count: $request['rooms_count'] ?? null,
            floor: $request['floor'] ?? null,
            area_min: $request['area_min'] ?? null,
            area_max: $request['area_max'] ?? null,
            type: $request['type'] ?? null,
            price_min: $request['price_min'] ?? null,
            price_max: $request['price_max'] ?? null,
        );
    }

    public function toArray()
    {
        return array_filter([
            'location_id' => $this->location_id,
            'rooms_count' => $this->rooms_count,
            'floor'       => $this->floor,
            'area_min'    => $this->area_min,
            'area_max'    => $this->area_max,
            'type'        => $this->type,
            'price_min'   => $this->price_min,
            'price_max'   => $this->price_max
        ], fn($value) => !is_null($value) && $value !== '');
    }
}
