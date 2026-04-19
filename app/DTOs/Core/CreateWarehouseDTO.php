<?php

namespace App\DTOs\Core;

class CreateWarehouseDTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $location
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            id: null,
            name: $request['name'],
            location: $request['location']
        );
    }

    public function toArray(): array
    {
        return [
            'name'      => $this->name,
            'location'  => $this->location
        ];
    }
}
