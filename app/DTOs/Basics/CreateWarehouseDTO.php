<?php

namespace App\DTOs\Basics;

class CreateWarehouseDTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $location
    ) {}

    public function toArray(): array
    {
        return [
            'name'      => $this->name,
            'location'  => $this->location
        ];
    }
}
