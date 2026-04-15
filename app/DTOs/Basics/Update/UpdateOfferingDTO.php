<?php

namespace App\DTOs\Basics\Update;

class UpdateOfferingDTO
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $description = null,
        public ?float $price = null,
    ) {}

    public function toArray(): array
    {
        return [
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price,
        ];
    }
}
