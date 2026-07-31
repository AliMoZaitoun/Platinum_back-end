<?php

namespace App\DTOs\Sales\Create;

use App\Http\Requests\V1\Sales\CreateAppointmentRequest;

class CreateAppointmentDTO
{
    public function __construct(
        public ?int $orderId,
        public int $clientId,
        public int $createdById,
        public string $createdByType,
        public int $avSlotId,
        public string $status,
        public ?string $type,
        public ?string $notes,
    ) {}

    public static function fromRequest(CreateAppointmentRequest $request): self
    {
        $user = $request->user();

        $clientId = $user->type === 'client'
            ? $user->client->id
            : (int) $request->input('client_id');

        return new self(
            orderId: $request->input('order_id') ?? null,
            clientId: $clientId,
            createdById: $user->id,
            createdByType: get_class($user),
            avSlotId: (int) $request->input('av_slot_id'),
            type: $request->input('type') ?? null,
            notes: $request->input('notes') ?? null,
            status: 'pending',
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'order_id'        => $this->orderId,
            'client_id'       => $this->clientId,
            'created_by_id'   => $this->createdById,
            'created_by_type' => $this->createdByType,
            'av_slot_id'      => $this->avSlotId,
            'status'          => $this->status,
            'type'            => $this->type,
            'notes'           => $this->notes,
        ], fn($value) => !is_null($value));
    }
}
