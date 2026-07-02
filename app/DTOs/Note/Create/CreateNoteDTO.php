<?php

namespace App\DTOs\Note\Create;

class CreateNoteDTO
{
    public function __construct(
        public string $text,
        public int $created_by,
    ) {}

    public static function fromRequest(int $created_by, array $request)
    {
        return new self(
            text: $request['note'],
            created_by: $created_by,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'text'       => $this->text,
            'created_by' => $this->created_by,
        ], fn($v) => !is_null($v));
    }
}
