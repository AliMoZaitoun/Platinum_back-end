<?php

namespace App\DTOs\Core\Update;

class UpdateSolutionDTO
{
    public function __construct(
        public ?string $name = null,
        public ?string $description = null,
        public ?float $price = null,
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            name: $request['name'] ?? null,
            description: $request['description'] ?? null,
            price: $request['price'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ], fn($value) => !is_null($value));
    }
}
