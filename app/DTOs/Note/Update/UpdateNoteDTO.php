<?php

namespace App\DTOs\Note\Update;

class UpdateNoteDTO
{
    public function __construct(
        public string $text,
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            text: $request['note'],
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'text'              => $this->text,
        ], fn($v) => !is_null($v));
    }
}
