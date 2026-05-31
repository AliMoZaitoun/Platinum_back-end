<?php

namespace App\DTOs\Sales\Update;

class UpdateComplaintTypeDTO
{
    public function __construct(
        public ?string $title,
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            title: $request['title'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'title'            => $this->title,
        ], fn($value) => !is_null($value));
    }
}
