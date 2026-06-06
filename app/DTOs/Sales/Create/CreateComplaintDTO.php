<?php

namespace App\DTOs\Sales\Create;

class CreateComplaintDTO
{
    public function __construct(
        public int $client_id,
        public ?int $user_id,
        public ?int $unit_id,
        public ?int $complaint_type_id,
        public ?string $new_type,
        public string $title,
        public string $body,
        public ?string $status,
    ) {}

    public static function fromRequest(int $user_id, int $client_id, array $request)
    {
        return new self(
            client_id: $client_id,
            user_id: $user_id,
            unit_id: $request['unit_id'] ?? null,
            complaint_type_id: $request['complaint_type_id'] ?? null,
            new_type: $request['new_type'] ?? null,
            title: $request['title'],
            body: $request['body'],
            status: $request['status'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'client_id'         => $this->client_id,
            'unit_id'           => $this->unit_id,
            'complaint_type_id' => $this->complaint_type_id,
            'title'             => $this->title,
            'body'              => $this->body,
            'status'            => $this->status,
        ], fn($value) => !is_null($value));
    }
}
