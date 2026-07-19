<?php

namespace App\Http\Resources\V1\Sales;

use App\Http\Resources\V1\ClientDetailResource;
use App\Http\Resources\V1\EmployeeDetailResource;
use App\Http\Resources\V1\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientContractResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'order'                 => new ClientOrderResource($this->whenLoaded('order')),
            'client'                => new ClientDetailResource($this->whenLoaded('client')),
            'employee'              => new EmployeeDetailResource($this->whenLoaded('employee')),

            'total_price'           => $this->total_price,
            'down_payment_amount'   => $this->down_payment_amount,
            'installments_count'    => $this->installments_count,

            'payments'              => PaymentResource::collection($this->whenLoaded('payments')),

            'created_at'     => $this->created_at->format('Y-m-d h:i A'),
            'attachments'   => MediaResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
