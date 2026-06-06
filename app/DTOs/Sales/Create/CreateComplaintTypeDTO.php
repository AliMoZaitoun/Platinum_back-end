<?php

namespace App\DTOs\Sales\Create;

class CreateComplaintTypeDTO
{
    public function __construct(
        public string $title,
        public int $created_by
    ) {}

    public static function fromRequest(int $created_by, array $data)
    {
        return new self(
            title: $data['title'],
            created_by: $created_by
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'title'            => $this->title,
            'created_by'       => $this->created_by,
        ], fn($value) => !is_null($value));
    }
}
