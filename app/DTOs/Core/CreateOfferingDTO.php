<?php

namespace App\DTOs\Core;

class CreateOfferingDTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $description,
        public float $price
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            id: null,
            name: $request['name'],
            description: $request['description'] ?? null,
            price: $request['price']
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
