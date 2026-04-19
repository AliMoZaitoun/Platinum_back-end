<?php

namespace App\DTOs\Sales\Create;

class CreateAppointmentDTO
{
    public function __construct(
        public int $order_id,
        public int $av_slot_id,
        public int $client_id,
        public int $created_by,
        public string $status
    ) {}

    public static function fromRequest(array $request)
    {
        return new self(
            order_id: $request['order_id'],
            av_slot_id: $request['av_slot_id'],
            client_id: $request['client_id'],
            created_by: $request['created_by'],
            status: $request['status']
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'order_id'    => $this->order_id,
            'av_slot_id' => $this->av_slot_id,
            'client_id'  => $this->client_id,
            'created_by'  => $this->created_by,
            'status'     => $this->status
        ], fn($value) => !is_null($value));
    }
}
