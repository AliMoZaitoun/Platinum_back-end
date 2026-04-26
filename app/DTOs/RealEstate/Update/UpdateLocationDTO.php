<?php

namespace App\DTOs\RealEstate\Update;

class UpdateLocationDTO
{
    public function __construct(
        public ?string $name,
        public ?string $type,
        public ?int $parent_id
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            name: $request['name'] ?? null,
            type: $request['type'] ?? null,
            parent_id: $request['parent_id'] ?? null
        );
    }

    public function toArray()
    {
        return array_filter([
            'name'  => $this->name,
            'type'  => $this->type,
            'parent_id'  => $this->parent_id
        ], fn($value) => !is_null($value));
    }
}
