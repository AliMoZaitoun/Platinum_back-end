<?php

namespace App\DTOs\Lottery\Create;

class CreateLotteryParticipateDTO
{
    public function __construct(
        public int $lottery_id,
        public int $client_id,
        public ?string $entry_date,
        public bool $is_winner,
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            lottery_id: $request['lottery_id'],
            entry_date: $request['entry_date'] ?? null,
            client_id: $request['client_id'],
            is_winner: $request['is_winner'] ?? false
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'lottery_id'    => $this->lottery_id,
            'entry_date'    => $this->entry_date,
            'client_id'     => $this->client_id,
            'is_winner'     => $this->is_winner
        ], fn($v) => !is_null($v));
    }
}
