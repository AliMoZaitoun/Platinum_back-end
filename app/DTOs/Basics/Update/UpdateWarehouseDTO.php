<?php

namespace App\DTOs\Basics\Update;

class UpdateWarehouseDTO
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $location = null
    ) {}

    public function toArray(): array
    {
        return [
            'name'     => $this->name,
            'location' => $this->location,
        ];
    }
}
