<?php

namespace App\DTOs\Marketing\Create;

class CreateAdDTO
{
    public function __construct(
        public string $title,
        public string $description,
        public string $duration,
        public string $status = 'enabled',
        public int $created_by,
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            title: $request['title'],
            description: $request['description'],
            duration: $request['duration'],
            status: $request['status'],
            created_by: $request['created_by'],
        );
    }

    public function toArray()
    {
        return array_filter([
            'title'  => $this->title,
            'description'  => $this->description,
            'duration'  => $this->duration,
            'status' => $this->status,
            'created_by' => $this->created_by
        ], fn($value) => !is_null($value));
    }
}
