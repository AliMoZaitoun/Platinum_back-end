<?php

namespace App\DTOs\RealEstate\Create;

class CreateUnitDTO
{
    public function __construct(
        public int $building_id,
        public string $unit_number,
        public int $floor,
        public float $area,
        public string $type,
        public float $price,
        public string $status
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            building_id: $request['building_id'],
            unit_number: $request['unit_number'],
            floor: $request['floor'],
            area: $request['area'],
            type: $request['type'],
            price: $request['price'],
            status: $request['status']
        );
    }

    public function toArray()
    {
        return array_filter([
            'building_id'  => $this->building_id,
            'unit_number'  => $this->unit_number,
            'floor'        => $this->floor,
            'area'         => $this->area,
            'type'         => $this->type,
            'price'        => $this->price,
            'status'       => $this->status
        ], fn($value) => !is_null($value));
    }
}
