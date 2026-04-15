<?php

namespace App\DTOs\Basics;

class CreateOfferingDTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $description,
        public float $price
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ];
    }
}
