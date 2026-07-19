<?php

namespace App\Http\Resources\V1\Sales;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractPaymentsGroupResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'contract_id' => $this->resource->first()?->contract_id,
            'payments'    => ClientPaymentResource::collection($this->resource),
        ];
    }
}
