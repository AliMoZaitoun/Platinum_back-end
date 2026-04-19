<?php

namespace App\DTOs\RealEstate\Update;

class UpdateUnitDTO
{
    public function __construct(
        public ?int $building_id,
        public ?string $unit_number,
        public ?int $floor,
        public ?float $area,
        public ?string $type,
        public ?float $price,
        public ?string $status
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            building_id: $request['building_id'] ?? null,
            unit_number: $request['unit_number'] ?? null,
            floor: $request['floor'] ?? null,
            area: $request['area'] ?? null,
            type: $request['type'] ?? null,
            price: $request['price'] ?? null,
            status: $request['status'] ?? null
        );
    }

    public function toArray()
    {
        return array_filter([
            'building_id'  => $this->building_id,
            'unit_number'  => $this->unit_number,
            'floor'  => $this->floor,
            'area'  => $this->area,
            'type'  => $this->type,
            'price'  => $this->price,
            'status' => $this->status
        ], fn($value) => !is_null($value));
    }
}
