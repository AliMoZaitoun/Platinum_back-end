<?php

namespace App\DTOs\Sales\Update;

class UpdateComplaintDTO
{
    public function __construct(
        public ?int $complaint_type_id,
        public ?string $title,
        public ?string $body,
        public ?string $status,
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            complaint_type_id: $request['complaint_type_id'] ?? null,
            title: $request['title'] ?? null,
            body: $request['body'] ?? null,
            status: $request['status'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'complaint_type_id' => $this->complaint_type_id,
            'title'             => $this->title,
            'body'              => $this->body,
            'status'            => $this->status,
        ], fn($value) => !is_null($value));
    }
}
