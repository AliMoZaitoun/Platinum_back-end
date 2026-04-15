<?php

namespace App\DTOs\Basics\Update;

class UpdateItemDTO
{
    public function __construct(
        public ?int $id = null,
        public ?string $sku = null,
        public ?string $name = null,
        public ?string $description = null,
        public ?int $quantity = null,
        public ?string $status = null,
        public ?\DateTime $expiry_date = null,
        public ?\DateTime $purchase_date = null,
        public ?\DateTime $received_date = null,
    ) {}

    public function toArray(): array
    {
        return [
            'sku'           => $this->sku,
            'name'          => $this->name,
            'description'   => $this->description,
            'quantity'      => $this->quantity,
            'status'        => $this->status,
            'expiry_date'   => $this->expiry_date,
            'purchase_date' => $this->purchase_date,
            'received_date' => $this->received_date,
        ];
    }
}
