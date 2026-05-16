<?php

namespace App\DTOs\Core\Create;

class CreateWarehouseDTO
{
    public function __construct(
        public string $name,
        public int $location_id,
        public string $address,
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            name: $request['name'],
            location_id: $request['location_id'],
            address: $request['address'],
        );
    }

    public function toArray(): array
    {
        return [
            'name'      => $this->name,
            'location_id'  => $this->location_id,
            'address'      => $this->address,
        ];
    }
}
