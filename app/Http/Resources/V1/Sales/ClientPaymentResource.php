<?php

namespace App\Http\Resources\V1\Sales;

use App\Http\Resources\V1\ClientDetailResource;
use App\Http\Resources\V1\MediaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientPaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'contract'          => new ClientContractResource($this->whenLoaded('contract')),
            'client'            => new ClientDetailResource($this->whenLoaded('client')),
            'employee'          => $this->employee->user->fullName,

            'amount'            => $this->amount,
            'payment_date'      => $this->payment_date,
            'payment_method'    => $this->payment_method,
            'payment_type'      => $this->payment_type,
            'status'            => $this->status,

            'created_at'        => $this->created_at->format('Y-m-d h:i A'),

            'attachments'   => MediaResource::collection($this->whenLoaded('attachments')),

        ];
    }
}
