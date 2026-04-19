<?php

namespace App\DTOs\Core\Update;

class UpdateWarehouseDTO
{
    public function __construct(
        public ?string $name = null,
        public ?string $location = null
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            name: $request['name'] ?? null,
            location: $request['location'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name'     => $this->name,
            'location' => $this->location,
        ], fn($value) => !is_null($value));
    }
}
