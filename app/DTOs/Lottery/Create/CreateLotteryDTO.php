<?php

namespace App\DTOs\Lottery\Create;

class CreateLotteryDTO
{
    public function __construct(
        public string $title,
        public ?string $status,
        public int $unit_id,
        public array $rules
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            title: $request['title'],
            status: $request['status'] ?? 'open',
            unit_id: $request['unit_id'],
            rules: $request['rules']
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'title'       => $this->title,
            'status'      => $this->status,
            'unit_id'     => $this->unit_id
        ], fn($v) => !is_null($v));
    }
}
