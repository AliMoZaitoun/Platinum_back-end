<?php

namespace App\DTOs\Client\Create;

class CreateFavoriteDTO
{
    public function __construct(
        public ?int $client_id,
        public int $unit_id,
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            client_id: $request['client_id'],
            unit_id: $request['unit_id']
        );
    }

    public function toArray()
    {
        return [
            'client_id' => $this->client_id,
            'unit_id' => $this->unit_id
        ];
    }
}
