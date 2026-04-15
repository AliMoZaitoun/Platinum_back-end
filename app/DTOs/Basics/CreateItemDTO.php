<?php

namespace App\DTOs\Basics;

class CreateItemDTO
{
    public function __construct(
        public ?int $id,
        public ?int $warehouseID,
        public string $sku,
        public string $name,
        public ?string $description,
        public int $quantity,
        public string $status,
        public \DateTime $expiry_date,
        public \DateTime $purchase_date,
        public \DateTime $received_date,
    ) {}

    public function toArray(): array
    {
        return [
            'warehouse_id'   => $this->warehouseID,
            'sku'            => $this->sku,
            'name'           => $this->name,
            'description'    => $this->description,
            'quantity'       => $this->quantity,
            'status'         => $this->status,
            'expiry_date'    => $this->expiry_date,
            'purchase_date'  => $this->purchase_date,
            'received_date'  => $this->received_date,
        ];
    }
}
