<?php

namespace App\DTOs\RealEstate\Create;

class CreateLocationDTO
{
    public function __construct(
        public string $name,
        public string $type,
        public int $parent_id
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            name: $request['name'],
            type: $request['type'],
            parent_id: $request['parent_id']
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
