<?php

namespace App\DTOs\Lottery\Update;

class UpdateLotteryDTO
{
    public function __construct(
        public ?string $title,
        public ?string $status,
        public ?int $unit_id,
        public ?int $winner_client_id
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            title: $request['title'] ?? null,
            status: $request['status'] ?? 'open',
            unit_id: $request['unit_id'] ?? null,
            winner_client_id: $request['winner_client_id'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'title'              => $this->title,
            'status'             => $this->status,
            'unit_id'            => $this->unit_id,
            'winner_client_id'   => $this->winner_client_id
        ], fn($v) => !is_null($v));
    }
}
