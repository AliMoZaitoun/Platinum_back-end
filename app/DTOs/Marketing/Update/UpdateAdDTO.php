<?php

namespace App\DTOs\Marketing\Update;

class UpdateAdDTO
{
    public function __construct(
        public ?string $title,
        public ?string $description,
        public ?string $duration,
        public ?string $status = 'enabled'
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            title: $request['title'],
            description: $request['description'],
            duration: $request['duration'],
            status: $request['status']
        );
    }

    public function toArray()
    {
        return array_filter([
            'title'  => $this->title,
            'description'  => $this->description,
            'duration'  => $this->duration,
            'status' => $this->status
        ], fn($value) => !is_null($value));
    }
}
